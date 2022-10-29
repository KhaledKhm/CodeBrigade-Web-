<?php

namespace App\Repository;

use App\Entity\Entretien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Entretien|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entretien|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entretien[]    findAll()
 * @method Entretien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntretienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entretien::class);
    }

    // /**
    //  * @return Entretien[] Returns an array of Entretien objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Entretien
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return Entretien[] Returns an array of user objects
     */

    public function sortByTitleASC()
    {
        $entretien = $this->createQueryBuilder('e')
            ->orderBy('e.Libelle', 'ASC');
        $query = $entretien->getQuery();
        return $query->execute();
    }

    /**
     * @return Entretien[] Returns an array of user objects
     */

    public function sortByTitleDSC()
    {
        $entretien = $this->createQueryBuilder('e')
            ->orderBy('e.Libelle', 'DESC');
        $query = $entretien->getQuery();
        return $query->execute();
    }
}
