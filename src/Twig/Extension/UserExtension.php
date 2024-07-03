<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\UserRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class UserExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('profile_picture', [UserRuntime::class, 'getProfilePicture']),
        ];
    }
}
