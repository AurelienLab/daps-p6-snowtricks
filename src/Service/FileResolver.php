<?php

namespace App\Service;

use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class FileResolver
{
    public function __construct(
        private readonly PropertyAccessorInterface  $propertyAccessor,
        private readonly FileUploaderConfigResolver $configResolver
    )
    {
    }

    /**
     * @throws Exception
     */
    public function resolve(mixed $object, string $uploadTarget): ?string
    {

        $uploadConfig = $this->configResolver->resolve($uploadTarget);

        if ($object instanceof $uploadConfig['entity'] === false) {
            throw new Exception(sprintf('Upload target %s expect an object of type %s, %s provided', $uploadTarget, $uploadConfig['entity'], get_class($object)));
        }

        $filename = $this->propertyAccessor->getValue($object, $uploadConfig['property']);

        if (empty($filename)) {
            return null;
        }

        $filePath = '/' . trim($uploadConfig['directory'], '/') . '/' . trim($filename, '/');

        $filesystem = new Filesystem();
        if ($filesystem->exists(ltrim($filePath, '/')) === false) {
            throw new FileNotFoundException(sprintf('Unable to find file %s', $filePath));
        }

        return '/' . ltrim($filePath, '/');
    }
}