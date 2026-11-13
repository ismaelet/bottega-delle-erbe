<?php

namespace App\Services;

use App\Models\Item;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class ProductCsvImport
{
    /**
     * @return list<string> Names not found in update-only mode.
     */
    public function import(UploadedFile $file, bool $updateOnly): array
    {
        $stream = fopen($file->getRealPath(), 'rb');
        if ($stream === false) {
            throw new RuntimeException('Impossibile leggere il file CSV.');
        }

        $rows = [];
        $names = [];
        $line = 0;
        try {
            while (($row = fgetcsv($stream, 0, ';', '"', '')) !== false) {
                $line++;
                if ($line === 1 && str_starts_with(mb_strtolower(ltrim($row[0] ?? '', "\xEF\xBB\xBF \t")), 'nome')) {
                    continue;
                }
                if (count($row) === 1 && trim($row[0] ?? '') === '') {
                    continue;
                }
                if (count($row) !== 8) {
                    throw ValidationException::withMessages(['file' => "La riga $line deve contenere 8 colonne."]);
                }
                $row = array_map(fn ($value) => trim($value), $row);
                $data = array_combine(['name', 'type', 'tech', 'info', 'methods', 'ingredients', 'warnings', 'price'], $row);
                if ($data['name'] === '') {
                    throw ValidationException::withMessages(['file' => "Riga $line: il nome è obbligatorio."]);
                }
                $name = mb_strtolower($data['name']);
                if (isset($names[$name])) {
                    throw ValidationException::withMessages(['file' => "Riga $line: prodotto duplicato nel file."]);
                }
                $names[$name] = true;
                $data['price'] = str_replace(',', '.', $data['price']);
                $item = Item::query()->where('name', $data['name'])->first();
                if ($item && $updateOnly) {
                    $data = array_filter($data, fn ($value) => $value !== '');
                }
                if ($item) {
                    unset($data['name'], $data['type']);
                }
                $rules = [
                    'name' => [$item ? 'sometimes' : 'required', 'string', 'max:50'],
                    'type' => [$item ? 'sometimes' : 'required', 'string', 'max:3', 'exists:items_types,tag'],
                    'tech' => ['sometimes', 'string', 'max:100'],
                    'info' => ['sometimes', 'string', 'max:500'],
                    'methods' => ['sometimes', 'string', 'max:400'],
                    'ingredients' => ['sometimes', 'string', 'max:800'],
                    'warnings' => ['sometimes', 'string', 'max:600'],
                    'price' => ['sometimes', 'numeric', 'min:0'],
                ];
                if (! $item && $updateOnly) {
                    $rows[] = ['missing' => $data['name']];

                    continue;
                }
                if (array_key_exists('price', $data) && $data['price'] === '') {
                    $data['price'] = 0;
                }
                $validator = Validator::make($data, $rules);
                if ($validator->fails()) {
                    throw ValidationException::withMessages(['file' => "Riga $line: ".$validator->errors()->first()]);
                }
                $rows[] = ['item' => $item, 'data' => $data];
            }
        } finally {
            fclose($stream);
        }

        $missing = [];
        foreach ($rows as $row) {
            if (isset($row['missing'])) {
                $missing[] = $row['missing'];

                continue;
            }
            if ($row['item']) {
                $row['item']->update($row['data']);
            } else {
                Item::query()->create($row['data']);
            }
        }

        return $missing;
    }
}
