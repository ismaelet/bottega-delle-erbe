<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use UnexpectedValueException;

class ProductCatalog
{
    public function decorate(Collection $products): Collection
    {
        $types = DB::table('items_types')->get(['tag', 'name'])->keyBy('tag');

        foreach ($products as $product) {
            if (! preg_match('/\A[a-z0-9_-]{1,3}\z/i', $product->type)) {
                throw new UnexpectedValueException('Invalid product type in the legacy database.');
            }

            $upload = "items/{$product->type}/{$product->id}.jpg";
            $product->image = Storage::disk('public')->exists($upload)
                ? asset('storage/'.$upload)
                : asset("legacy/app/resources/images/items/{$product->type}.png");
            $product->typeName = $types->get($product->type)?->name;
        }

        return $products;
    }
}
