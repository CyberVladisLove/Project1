<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class GuestVoter extends Voter
{
    public const EDIT = 'EDIT';
    public const VIEW = 'VIEW';
    public const NEW = 'NEW';
    public const DEL = 'DEL';

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW, self::NEW, self::DEL])
            && $subject instanceof \App\Entity\Guest;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        //return true;
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }
        $guest = $subject;

        switch ($attribute) {
            case self::DEL:
            case self::EDIT:
                return
                    in_array('ROLE_ADMIN', $user->getRoles())
                    || $guest->getAuthor() != null
                    || $user->getUserIdentifier() == $guest->getByUser()->getUserIdentifier()
                    || $user->getUserIdentifier() == $guest->getAuthor()->getUserIdentifier();

            case self::NEW:
            case self::VIEW:
                return in_array('ROLE_USER', $user->getRoles());

        }

        return false;
    }
}
