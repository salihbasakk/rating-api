<?php

namespace App\Repository;

use App\Entity\Vico;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vico>
 *
 * @method Vico|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vico|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vico[]    findAll()
 * @method Vico[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VicoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vico::class);
    }

    public function save(Vico $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Vico $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
