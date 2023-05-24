<?php

namespace App\Repository;

use App\Entity\RatingQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RatingQuestion>
 *
 * @method RatingQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method RatingQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method RatingQuestion[]    findAll()
 * @method RatingQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RatingQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RatingQuestion::class);
    }

    public function save(RatingQuestion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RatingQuestion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
