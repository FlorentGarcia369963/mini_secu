<?php

namespace App\Repository;

use App\Entity\Requests;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @extends ServiceEntityRepository<Requests>
 */
class RequestsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Requests::class);
    }

//    /**
//     * @return Requests[] Returns an array of Requests objects
//     */

 public function findAllRequestsWithUser(string $role): array
 {
   
    if ($role === 'ROLE_ADVISOR') {
    return $this->createQueryBuilder('r')
    ->addSelect('user')
    ->leftJoin('r.userRequest', 'user')
    ->getQuery()
    ->getResult();
     } elseif ($role === 'ROLE_VALIDATOR') {
       
        return $this->createQueryBuilder('r')
        ->addSelect('user')
        ->leftJoin('r.userRequest', 'user')
        ->where('r.status = :status')
        ->setParameter('status', 'in_progress')
        ->getQuery()
        ->getResult();
    } else {
        throw new Exception('Rôle non reconnu');
    }
 }

//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Requests
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}