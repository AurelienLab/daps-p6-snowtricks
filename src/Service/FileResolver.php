<?php

namespace App\Service;

use Exception;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class FileResolver
{


    public function __construct(
        private readonly PropertyAccessorInterface  $propertyAccessor,
        private readonly FileUploaderConfigResolver $configResolver
    ) {
    }


    /**
     * Retrieve a file path from uploaded file in entity according to config
     *
     * @throws Exception
     */
    public function resolve(mixed $object, string $uploadTarget): ?string
    {
        $uploadConfig = $this->configResolver->resolve($uploadTarget);

        if ($object instanceof $uploadConfig['entity'] === false) {
            throw new Exception(sprintf('Upload target %s expect an object of type %s, %s provided', htmlentities($uploadTarget), $uploadConfig['entity'], get_class($object)));
        }

        $filename = $this->propertyAccessor->getValue($object, $uploadConfig['property']);

        if (empty($filename)) {
            return null;
        }

        $filePath = '/' . trim($uploadConfig['directory'], '/') . '/' . trim($filename, '/');

        $filesystem = new Filesystem();
        if ($filesystem->exists(ltrim($filePath, '/')) === false) {
            throw new FileNotFoundException(sprintf('Unable to find file %s', htmlentities($filePath)));
        }

        return '/' . ltrim($filePath, '/');
    }


}