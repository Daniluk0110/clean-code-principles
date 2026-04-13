<?php

declare(strict_types=1);

final class AvatarUploader
{
    public function __construct(private string $basePath)
    {
    }

    public function upload(int $userId, string $contents, string $extension): string
    {
        $path = "avatars/{$userId}.{$extension}";
        $fullPath = rtrim($this->basePath, '/').'/'.ltrim($path, '/');
        $dir = dirname($fullPath);

        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        file_put_contents($fullPath, $contents);

        return $path;
    }
}

$uploader = new AvatarUploader(__DIR__.'/storage');
$path = $uploader->upload(42, 'binary-image-data', 'png');

echo "Stored at: {$path}\n";
