<?php

namespace App\Security\Voter;

use App\Entity\Market;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class MarketVoter extends Voter
{
    protected function supports($attribute, $subject): bool
    {
        $supportsAttribute = in_array($attribute, ['MARKET_GET']);
        $supportsSubject = $subject instanceof Market;

        return $supportsAttribute && $supportsSubject;
    }

    /**
     * @param string $attribute
     * @param Market $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        switch ($attribute) {
            case 'MARKET_GET':
                return $subject->getUserId() === $user;
                break;
            case 'MARKET_OTHER':
        }

        return false;
    }
}