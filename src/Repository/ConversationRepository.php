<?php

namespace App\Repository;

use App\Entity\Conversation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use Doctrine\ORM\Query\Expr\Join;

/**
 * @method Conversation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conversation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conversation[]    findAll()
 * @method Conversation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conversation::class);
    }

    // /**
    //  * @return Conversation[] Returns an array of Conversation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Conversation
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */



    public function findConversationByParticipants(int $otherUserId, int $myId)
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->select($qb->expr()->count('p.conversation'))
            ->innerJoin('c.enqueteurs', 'p')
            ->where(
                $qb->expr()->orX(
                    $qb->expr()->eq('p.utilisateur', ':me'),
                    $qb->expr()->eq('p.utilisateur', ':otherUser')
                )
            )
            ->groupBy('p.conversation')
            ->having(
                $qb->expr()->eq(
                    $qb->expr()->count('p.conversation'),
                    2
                )
            )
            ->setParameters([
                'me' => $myId,
                'otherUser' => $otherUserId
            ])
        ;

        return $qb->getQuery()->getResult();
    }

    public function findConversationsByUser(int $userId)
    {
        $qb = $this->createQueryBuilder('c');
        $qb

            ->select('otherUser.nom', 'c.id as conversationId', 'lm.content', 'lm.createdAt')
            ->innerJoin('c.enqueteurs', 'p', Join::WITH, $qb->expr()->neq('p.utilisateur', ':utilisateur'))
            ->innerJoin('c.enqueteurs', 'me', Join::WITH, $qb->expr()->eq('me.utilisateur', ':utilisateur'))
           ->leftJoin('c.lastMessage', 'lm')
            ->innerJoin('me.utilisateur', 'meUser')
            ->innerJoin('p.utilisateur', 'otherUser')
            ->where('meUser.id = :utilisateur')
            ->setParameter('utilisateur', $userId)
            ->orderBy('lm.createdAt', 'DESC')
        ;

        return $qb->getQuery()->getResult();
    }
    public function checkIfUserisParticipant(int $conversationId, int $userId)
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->innerJoin('c.enqueteurs', 'p')
            ->where('c.id = :conversationId')
            ->andWhere(
                $qb->expr()->eq('p.utilisateur', ':utilisateurId')
            )
            ->setParameters([
                'conversationId' => $conversationId,
                'utilisateurId' => $userId
            ])
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }
}
