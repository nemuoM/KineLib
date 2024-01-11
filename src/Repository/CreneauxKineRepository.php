<?php

namespace App\Repository;

use App\Entity\CreneauxKine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CreneauxKine>
 *
 * @method CreneauxKine|null find($id, $lockMode = null, $lockVersion = null)
 * @method CreneauxKine|null findOneBy(array $criteria, array $orderBy = null)
 * @method CreneauxKine[]    findAll()
 * @method CreneauxKine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreneauxKineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreneauxKine::class);
    }

    public function findByKineId($kineId)
    {
        return $this->createQueryBuilder('ck')
            ->andWhere('ck.idKine = :kineId')
            ->setParameter('kineId', $kineId)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return CreneauxKine[] Returns an array of CreneauxKine objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CreneauxKine
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
