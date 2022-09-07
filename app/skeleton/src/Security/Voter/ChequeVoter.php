<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ChequeVoter extends Voter
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
            && $subject instanceof \App\Entity\Cheque;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        return true;
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        $cheque = $subject;
        switch ($attribute) {
            case self::DEL:
            case self::EDIT:
                return
                    $cheque->getAuthor() != null
                    && (
                        in_array('ROLE_ADMIN', $user->getRoles())
                        || $user->getUserIdentifier() == $cheque->getAuthor()->getUserIdentifier()
                    );

            case self::NEW:
            case self::VIEW:
                return in_array('ROLE_USER', $user->getRoles());
        }

        return false;
    }
}
