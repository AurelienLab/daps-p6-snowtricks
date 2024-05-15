<?php

namespace App\Service;

use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class FileUploaderConfigResolver
{

    public function __construct(
        private readonly ParameterBagInterface $parameterBag,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function resolve(string $uploadTarget): array
    {
        $availableTargets = $this->parameterBag->get('upload_targets');

        if (!isset($availableTargets[$uploadTarget])) {
            throw new Exception(sprintf('No upload target found for %s in project parameters', $fileTarget));
        }

        return $availableTargets[$uploadTarget];
    }
}