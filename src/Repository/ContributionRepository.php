<?php

namespace App\Repository;

use App\Entity\Contribution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contribution>
 *
 * @method Contribution|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contribution|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contribution[]    findAll()
 * @method Contribution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContributionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contribution::class);
    }

    /**
     * @return Contributions[]
     */
    public function findContributionsByProject(int $id): array 
    {
        $entityManager = $this->getEntityManager(); 
        $query = $entityManager->createQuery('SELECT c FROM App\Entity\Contribution c WHERE c.project = :id')->setParameter('id', $id); 
        return $query->getResult(); 
    }
    /**
     * @return Contributions[]
     */
    public function findContributionsByUser(int $id): array 
    {
        $entityManager = $this->getEntityManager(); 
        $query = $entityManager->createQuery('SELECT c FROM App\Entity\Contribution c WHERE c.contributor = :id')->setParameter('id', $id); 
        return $query->getResult(); 
    }
    

//    /**
//     * @return Contribution[] Returns an array of Contribution objects
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

//    public function findOneBySomeField($value): ?Contribution
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
