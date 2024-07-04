<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\FileResolverExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class FileResolverExtension extends AbstractExtension
{

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_file_path', [FileResolverExtensionRuntime::class, 'getFilePath']),
        ];
    }
}
