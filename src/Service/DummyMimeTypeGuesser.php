<?php

namespace App\Service;

use Symfony\Component\Mime\MimeTypeGuesserInterface;

class DummyMimeTypeGuesser implements MimeTypeGuesserInterface
{
    public function guessMimeType(string $path): ?string
    {
        // Get extension from filename
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        // Return MIME type based on extension
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'pdf' => 'application/pdf',
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }

    public function isGuesserSupported(): bool
    {
        return true;
    }
}