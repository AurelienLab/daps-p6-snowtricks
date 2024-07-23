<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\TrickRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TrickExtension extends AbstractExtension
{


    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('trick_banner_picture', [TrickRuntime::class, 'getTrickBannerPicture']),
        ];
    }


}
