<?php

namespace App\EventListener;

use App\Entity\Livre;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class LivreFileUploadListener
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(Livre $livre, PrePersistEventArgs $args): void
    {
        $this->handleFileUpload($livre);
    }

    public function preUpdate(Livre $livre, PreUpdateEventArgs $args): void
    {
        $this->handleFileUpload($livre);
    }

    private function handleFileUpload(Livre $livre): void
    {
        $uploadedFile = $livre->getPdfFilename();

        // Check if it's an uploaded file
        if ($uploadedFile instanceof UploadedFile) {
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);

            // Get extension from client original name
            $extension = strtolower(pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_EXTENSION));

            // Validate extension
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array($extension, $allowedExtensions)) {
                $extension = 'jpg'; // default fallback
            }

            $fileName = $safeFilename.'-'.uniqid().'.'.$extension;

            // Ensure directory exists
            $uploadDir = 'public/uploads/images';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            try {
                $uploadedFile->move($uploadDir, $fileName);
                $livre->setPdfFilename($fileName);
            } catch (\Exception $e) {
                // Handle upload error - could log here
                $livre->setPdfFilename(null);
            }
        }
    }
}