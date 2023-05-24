<?php

namespace App\Repository;

use App\Entity\Feedback;
use App\Entity\Rating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rating>
 *
 * @method Rating|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rating|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rating[]    findAll()
 * @method Rating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RatingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rating::class);
    }

    public function save(Rating $entity, bool $flush = false): Rating
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
        return $entity;
    }

    public function remove(Rating $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Feedback $feedback
     * @return int|mixed|string|null
     * @throws NonUniqueResultException
     */
    public function getTotalRatingScoreCount(Feedback $feedback)
    {
        return $this->createQueryBuilder('r')
            ->select('SUM(r.score) as totalScore')
            ->where('r.feedback =:feedback')
            ->setParameter('feedback', $feedback)
            ->getQuery()->getOneOrNullResult();
    }

    /**
     * @param Feedback $feedback
     * @return int|mixed|string|null
     * @throws NonUniqueResultException
     */
    public function getRatingCount(Feedback $feedback)
    {
        return $this->createQueryBuilder('r')
            ->select('COUNT(r) as count')
            ->where('r.feedback =:feedback')
            ->setParameter('feedback', $feedback)
            ->getQuery()->getOneOrNullResult();
    }
}
