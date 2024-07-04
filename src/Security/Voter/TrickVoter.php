<?php

namespace App\Security\Voter;

use App\Entity\Trick;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class TrickVoter extends Voter
{
    public function __construct(
        private readonly Security $security,
    )
    {
    }

    public const EDIT = 'edit';
    public const DELETE = 'delete';


    /**
     * @inheritDoc
     */
    protected function supports(string $attribute, mixed $subject): bool
    {

        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof Trick;
    }


    /**
     * @inheritDoc
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        return match ($attribute) {
            self::EDIT => $this->canEdit($subject, $user),
            self::DELETE => $this->canDelete($subject, $user),
            default => false
        };
    }

    /**
     * Is the user allowed to edit the trick
     *
     * @param Trick $trick
     * @param User $user
     * @return bool
     */
    private function canEdit(Trick $trick, User $user): bool
    {
        return $this->security->isGranted('ROLE_ADMIN')
            || $trick->getAuthor() === $user;
    }


    /**
     * Is the user allowed to remove the trick
     *
     * @param Trick $trick
     * @param User $user
     * @return bool
     */
    private function canDelete(Trick $trick, User $user): bool
    {
        return $this->security->isGranted('ROLE_ADMIN')
            || $trick->getAuthor() === $user;
    }
}
