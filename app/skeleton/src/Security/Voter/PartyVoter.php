<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class PartyVoter extends Voter
{
    public const EDIT = 'EDIT';
    public const VIEW = 'VIEW';
    public const NEW = 'NEW';
    public const DEL = 'DEL';

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW, self::NEW, self::DEL])
            && $subject instanceof \App\Entity\Party;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        $party = $subject;
        switch ($attribute) {
            case self::DEL:
                return
                    in_array('ROLE_ADMIN', $user->getRoles())
                    || $user->getUserIdentifier() == $party->getAuthor()->getUserIdentifier();

            case self::EDIT:
                foreach ($party->getGuests() as $guest)
                    if($user->getUserIdentifier() == $guest->getByUser()->getUserIdentifier()) return true;

                return
                    in_array('ROLE_ADMIN', $user->getRoles())
                    || $user->getUserIdentifier() == $party->getAuthor()->getUserIdentifier();

            case self::NEW:
            case self::VIEW:
                return in_array('ROLE_USER', $user->getRoles());
        }
        return false;
    }
}
