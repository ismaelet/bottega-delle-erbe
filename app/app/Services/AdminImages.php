<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Item;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class AdminImages
{
    /**
     * The old product paths are retained when changing type so a failed update
     * never removes the images still referenced by the database.
     */
    public function save(Model $record, ?UploadedFile $upload, ?string $previousType = null): void
    {
        if ($record instanceof Item && (! preg_match('/\A[a-z0-9_-]{1,3}\z/i', $record->type) || ($previousType !== null && ! preg_match('/\A[a-z0-9_-]{1,3}\z/i', $previousType)))) {
            throw new RuntimeException('Tipo prodotto non valido.');
        }
        $directory = match (true) {
            $record instanceof Item => 'items/'.$record->type,
            $record instanceof Post => 'blog',
            $record instanceof Course => 'courses',
            default => throw new RuntimeException('Unsupported image record.'),
        };
        $disk = Storage::disk('public');
        $paths = ["$directory/{$record->getKey()}.jpg", "$directory/{$record->getKey()}_m.jpg"];
        $contents = [];

        if ($upload) {
            $contents = file_get_contents($upload->getRealPath());
            if ($contents === false) {
                throw new RuntimeException('Impossibile leggere l’immagine.');
            }
            $source = imagecreatefromstring($contents);
            if ($source === false) {
                throw new RuntimeException('Impossibile leggere l’immagine.');
            }

            try {
                $contents = match (true) {
                    $record instanceof Item => [$this->resize($source, 1024), $this->resize($source, 450, quality: 70)],
                    $record instanceof Post => [$this->resize($source, 1920), $this->resize($source, 500, 700, 70)],
                    $record instanceof Course => [$this->resize($source, 1920), $this->resize($source, 800, quality: 70)],
                };
            } finally {
                imagedestroy($source);
            }
        } elseif ($record instanceof Item && $previousType !== null && $previousType !== $record->type) {
            foreach (["items/$previousType/{$record->getKey()}.jpg", "items/$previousType/{$record->getKey()}_m.jpg"] as $index => $oldPath) {
                $content = $disk->exists($oldPath) ? $disk->get($oldPath) : null;
                if ($disk->exists($oldPath) && $content === null) {
                    throw new RuntimeException("Impossibile leggere l’immagine: $oldPath");
                }
                if ($content === null && $disk->exists($paths[$index])) {
                    throw new RuntimeException("Immagine di destinazione già presente: {$paths[$index]}");
                }
                $contents[] = $content;
            }
        } else {
            return;
        }

        $backups = [];
        foreach ($paths as $path) {
            $backups[$path] = $disk->exists($path) ? $disk->get($path) : null;
            if ($disk->exists($path) && $backups[$path] === null) {
                throw new RuntimeException("Impossibile leggere l’immagine: $path");
            }
        }

        try {
            foreach ($paths as $index => $path) {
                if ($contents[$index] !== null && ! $disk->put($path, $contents[$index])) {
                    throw new RuntimeException("Impossibile salvare l’immagine: $path");
                }
            }
        } catch (Throwable $exception) {
            foreach ($backups as $path => $backup) {
                $restored = $backup === null ? $disk->delete($path) : $disk->put($path, $backup);
                if (! $restored) {
                    throw new RuntimeException("Impossibile ripristinare l’immagine: $path", previous: $exception);
                }
            }

            throw $exception;
        }
    }

    private function resize(\GdImage $source, int $width, ?int $height = null, int $quality = 80): string
    {
        $sourceWidth = imagesx($source);
        $sourceHeight = imagesy($source);
        $x = $y = 0;
        if ($height === null) {
            $scale = $width / max($sourceWidth, $sourceHeight);
            $height = max(1, (int) round($sourceHeight * $scale));
            $width = max(1, (int) round($sourceWidth * $scale));
        } elseif ($sourceWidth / $sourceHeight > $width / $height) {
            $cropWidth = (int) round($sourceHeight * $width / $height);
            $x = (int) (($sourceWidth - $cropWidth) / 2);
            $sourceWidth = $cropWidth;
        } else {
            $cropHeight = (int) round($sourceWidth * $height / $width);
            $y = (int) (($sourceHeight - $cropHeight) / 2);
            $sourceHeight = $cropHeight;
        }

        $image = imagecreatetruecolor($width, $height);
        if ($image === false || ! imagecopyresampled($image, $source, 0, 0, $x, $y, $width, $height, $sourceWidth, $sourceHeight)) {
            throw new RuntimeException('Impossibile ridimensionare l’immagine.');
        }

        ob_start();
        try {
            if (! imagejpeg($image, null, $quality)) {
                throw new RuntimeException('Impossibile convertire l’immagine.');
            }

            $content = ob_get_contents();
            if ($content === false) {
                throw new RuntimeException('Impossibile leggere l’immagine convertita.');
            }

            return $content;
        } finally {
            ob_end_clean();
            imagedestroy($image);
        }
    }
}
