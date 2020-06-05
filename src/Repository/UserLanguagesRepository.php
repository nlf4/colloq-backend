<?php

namespace App\Repository;

use App\Entity\UserLanguages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserLanguages|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserLanguages|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserLanguages[]    findAll()
 * @method UserLanguages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserLanguagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserLanguages::class);
    }

    // /**
    //  * @return UserLanguages[] Returns an array of UserLanguages objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserLanguages
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
