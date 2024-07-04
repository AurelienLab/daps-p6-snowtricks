<?php

namespace App\Twig\Runtime;

use App\Service\FileResolver;
use Exception;
use Twig\Extension\RuntimeExtensionInterface;

class FileResolverExtensionRuntime implements RuntimeExtensionInterface
{

    public function __construct(
        private readonly FileResolver $fileResolver
    )
    {
        // Inject dependencies if needed
    }

    /**
     * Returns the file path according to the config
     *
     * @param mixed $object
     * @param string $uploadTarget
     * @return string|null
     * @throws Exception
     */
    public function getFilePath(mixed $object, string $uploadTarget): ?string
    {
        return $this->fileResolver->resolve($object, $uploadTarget);
    }
}
