<?php

namespace App\Security\Voter;

use App\Entity\Conversation;
use App\Entity\Utilisateur;
use App\Repository\ConversationRepository;
use phpDocumentor\Reflection\Types\Self_;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ConversationVoter extends Voter
{
    /**
     * @var $conversationRepository
     *
     */
    private $conversationRepository;

    public function __construct(ConversationRepository $conversationRepository)
    {
        $this->conversationRepository = $conversationRepository;

    }

    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['VIEW', 'POST', 'EDIT', 'DELETE'])
            && $subject instanceof Conversation;
   // dd($attribute,$attribute);
    //return $attribute == self::VIEW && $subject instanceof Conversation;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        /** @var Utilisateur $user */
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // you know $subject is a Conversation object, thanks to supports
        /** @var Conversation $subject */
//dd($token,$attribute,$subject);
        $result = $this->conversationRepository->checkIfUserisParticipant( $subject->getId(),$token->getUser()->getId());
//dd($result);
//return !!$result;
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'VIEW':
                return $result;
                break;
            case 'EDIT':
            case 'DELETE':
        }

        return false;
    }

}
