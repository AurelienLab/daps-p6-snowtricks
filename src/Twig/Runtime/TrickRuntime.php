<?php

namespace App\Twig\Runtime;

use App\Entity\Trick;
use App\Service\FileResolver;
use Exception;
use Symfony\Component\Asset\Packages;
use Twig\Extension\RuntimeExtensionInterface;

class TrickRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private readonly FileResolver $fileResolver,
        private readonly Packages     $packages,
    )
    {
    }

    /**
     * Shorthand to get the trick banner picture or first media image or placeholder
     *
     * @throws Exception
     */
    public function getTrickBannerPicture(Trick $trick): string
    {
        if (!empty($trick->getFeaturedPicture())) {
            return $this->fileResolver->resolve($trick, 'trick_featured_picture');
        }

        if ($trick->getMediaImages()->count() > 0) {
            return $this->fileResolver->resolve($trick->getMediaImages()->first(), 'trick_media_image');
        }

        return $this->packages->getUrl('images/placeholder-hero.jpg');
    }
}
