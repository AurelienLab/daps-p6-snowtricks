<?php

namespace App\Service;

use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    public function __construct(
        private readonly SluggerInterface           $slugger,
        private readonly FileUploaderConfigResolver $configResolver,
        private readonly PropertyAccessorInterface  $propertyAccessor,
        private readonly FileResolver               $fileResolver
    )
    {
    }

    /**
     * @throws Exception
     */
    public function upload(UploadedFile $file, mixed $object, string $uploadTarget): string
    {
        $targetConfig = $this->configResolver->resolve($uploadTarget);

        if ($object instanceof $targetConfig['entity'] === false) {
            throw new Exception(sprintf('Upload target %s expect an object of type %s, %s provided', $uploadTarget, $targetConfig['entity'], get_class($object)));
        }

        $targetDirectory = $targetConfig['directory'];

        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        try {
            $file->move($targetDirectory, $fileName);

            // Remove old
            if (!empty($this->propertyAccessor->getValue($object, $targetConfig['property']))) {
                $filesystem = new Filesystem();
                $filesystem->remove(ltrim($this->fileResolver->resolve($object, $uploadTarget), '/'));
            }

            $this->propertyAccessor->setValue($object, $targetConfig['property'], $fileName);

        } catch (FileException $e) {
            return false;
        }

        return true;
    }

    /**
     * @throws Exception
     */

}