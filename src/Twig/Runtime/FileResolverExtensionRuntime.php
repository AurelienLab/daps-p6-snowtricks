<?php

namespace App\Twig\Runtime;

use App\Service\FileResolver;
use Twig\Extension\RuntimeExtensionInterface;

class FileResolverExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private readonly FileResolver $fileResolver
    )
    {
        // Inject dependencies if needed
    }

    public function getFilePath(mixed $object, string $uploadTarget)
    {
        return $this->fileResolver->resolve($object, $uploadTarget);
    }
}
