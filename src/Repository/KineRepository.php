<?php

namespace App\Repository;

use App\Entity\Kine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Kine>
 *
 * @method Kine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kine[]    findAll()
 * @method Kine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kine::class);
    }

//    /**
//     * @return Kine[] Returns an array of Kine objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('k')
//            ->andWhere('k.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('k.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Kine
//    {
//        return $this->createQueryBuilder('k')
//            ->andWhere('k.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
