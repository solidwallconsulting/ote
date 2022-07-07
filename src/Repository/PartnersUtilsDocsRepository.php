<?php

namespace App\Repository;

use App\Entity\PartnersUtilsDocs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PartnersUtilsDocs>
 *
 * @method PartnersUtilsDocs|null find($id, $lockMode = null, $lockVersion = null)
 * @method PartnersUtilsDocs|null findOneBy(array $criteria, array $orderBy = null)
 * @method PartnersUtilsDocs[]    findAll()
 * @method PartnersUtilsDocs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartnersUtilsDocsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PartnersUtilsDocs::class);
    }

    public function add(PartnersUtilsDocs $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PartnersUtilsDocs $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PartnersUtilsDocs[] Returns an array of PartnersUtilsDocs objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PartnersUtilsDocs
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
