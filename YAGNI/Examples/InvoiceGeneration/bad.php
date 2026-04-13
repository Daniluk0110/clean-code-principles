<?php

declare(strict_types=1);

interface StorageInterface
{
    public function put(string $path, string $contents): void;
}

final class LocalStorage implements StorageInterface
{
    public function __construct(private string $basePath)
    {
    }

    public function put(string $path, string $contents): void
    {
        $fullPath = rtrim($this->basePath, '/').'/'.ltrim($path, '/');
        $dir = dirname($fullPath);

        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        file_put_contents($fullPath, $contents);
    }
}

final class S3Storage implements StorageInterface
{
    public function __construct(
        private string $bucket,
        private string $accessKey,
        private string $secretKey,
    ) {
    }

    public function put(string $path, string $contents): void
    {
        throw new RuntimeException('S3 не настроен');
    }
}

final class AvatarUploader
{
    public function __construct(private StorageInterface $storage)
    {
    }

    public function upload(int $userId, string $contents, string $extension): string
    {
        $path = "avatars/{$userId}.{$extension}";
        $this->storage->put($path, $contents);

        return $path;
    }
}

$uploader = new AvatarUploader(new LocalStorage(__DIR__.'/storage'));
$path = $uploader->upload(42, 'binary-image-data', 'png');

echo "Stored at: {$path}\n";
