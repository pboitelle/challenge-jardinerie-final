<?php
// api/src/Security/Voter/BookVoter.php

namespace App\Security\Voter;

use App\Entity\Hackathon;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class HackathonVoter extends Voter
{
    protected function supports($attribute, $subject): bool
    {
        $supportsAttribute = in_array($attribute, ['HACKATHON_GET']);
        $supportsSubject = $subject instanceof Hackathon;

        return $supportsAttribute && $supportsSubject;
    }

    /**
     * @param string $attribute
     * @param Hackathon $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        switch ($attribute) {
            case 'HACKATHON_GET':
                return $subject->getParticipants()->contains($user);
                break;
            case 'HACKATHON_OTHER':
        }

        return false;
    }
}
