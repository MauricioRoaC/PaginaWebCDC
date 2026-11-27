<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublicMedia
{
    public static function cloud(): bool
    {
        return config('filesystems.media.driver') === 'supabase';
    }

    private static function endpoint(string $path): string
    {
        $base = rtrim((string) config('filesystems.media.url'), '/');
        $bucket = rawurlencode((string) config('filesystems.media.bucket'));
        return $base.'/storage/v1/object/'.$bucket.'/'.implode('/', array_map('rawurlencode', explode('/', $path)));
    }

    private static function client()
    {
        $key = config('filesystems.media.key');
        if (!$key || !str_starts_with((string) config('filesystems.media.url'), 'https://')) {
            throw new \RuntimeException('Supabase storage configuration is incomplete.');
        }
        return Http::withToken($key)->withHeaders(['apikey' => $key])->connectTimeout(10)->timeout(30);
    }

    public static function store(UploadedFile $file, string $directory): string
    {
        if (!self::cloud()) {
            return $file->store($directory, 'public');
        }
        $path = $directory.'/'.Str::uuid().'.'.$file->extension();
        self::client()->withHeaders(['x-upsert' => 'false'])
            ->withBody(file_get_contents($file->getRealPath()), $file->getMimeType())
            ->post(self::endpoint($path))->throw();
        return $path;
    }

    public static function delete(string $path): void
    {
        if (!self::cloud()) {
            Storage::disk('public')->delete($path);
            return;
        }
        self::client()->delete(self::endpoint($path))->throw();
    }

    public static function url(string $path): string
    {
        return str_replace('/storage/v1/object/', '/storage/v1/object/public/', self::endpoint($path));
    }
}
