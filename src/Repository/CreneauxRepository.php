<?php

namespace App\Repository;

use App\Entity\Creneaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Creneaux>
 *
 * @method Creneaux|null find($id, $lockMode = null, $lockVersion = null)
 * @method Creneaux|null findOneBy(array $criteria, array $orderBy = null)
 * @method Creneaux[]    findAll()
 * @method Creneaux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreneauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Creneaux::class);
    }

    public function findAvailableCreneauxForWeek(\DateTime $weekStart, \DateTime $weekEnd, $kineId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        
        // Début de la requête pour obtenir les créneaux horaires de 'CreneauxKine'
        $qb->select('ck')
        ->from('App\Entity\CreneauxKine', 'ck')
        ->innerJoin('ck.idCreneaux', 'c')
        ->innerJoin('ck.idKine', 'k')
        ->where('k.id = :kineId')
        ->setParameter('kineId', $kineId);
        
        // Sous-requête pour trouver les créneaux réservés
        $subQuery = $this->getEntityManager()->createQueryBuilder()
            ->select('IDENTITY(rdv.idCreneaux)')
            ->from('App\Entity\RendezVous', 'rdv')
            ->where('rdv.dateRdv BETWEEN :weekStart AND :weekEnd')
            ->andWhere('rdv.idKine = :kineId')
            ->getDQL();
        
        // Exclure les créneaux déjà réservés
        $qb->andWhere($qb->expr()->notIn('c.id', $subQuery))
        ->setParameter('weekStart', $weekStart->format('Y-m-d'))
        ->setParameter('weekEnd', $weekEnd->format('Y-m-d'));

        return $qb->getQuery()->getResult();
    }




//    /**
//     * @return Creneaux[] Returns an array of Creneaux objects
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

//    public function findOneBySomeField($value): ?Creneaux
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
