<?php

namespace App\Twig\Runtime;

use App\Entity\User;
use App\Service\FileResolver;
use Exception;
use Symfony\Component\Asset\Packages;
use Twig\Extension\RuntimeExtensionInterface;

class UserRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private readonly FileResolver $fileResolver,
        private readonly Packages     $packages,
    )
    {
    }


    /**
     * Shorthand to get user profile picture or placeholder
     * @throws Exception
     */
    public function getProfilePicture(User $user): string
    {
        if (!empty($user->getProfilePicture())) {
            return $this->fileResolver->resolve($user, 'user_profile');
        }

        return $this->packages->getUrl('images/placeholder-profile.svg');
    }


}
