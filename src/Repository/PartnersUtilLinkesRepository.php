<?php

namespace App\Repository;

use App\Entity\PartnersUtilLinkes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PartnersUtilLinkes>
 *
 * @method PartnersUtilLinkes|null find($id, $lockMode = null, $lockVersion = null)
 * @method PartnersUtilLinkes|null findOneBy(array $criteria, array $orderBy = null)
 * @method PartnersUtilLinkes[]    findAll()
 * @method PartnersUtilLinkes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartnersUtilLinkesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PartnersUtilLinkes::class);
    }

    public function add(PartnersUtilLinkes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PartnersUtilLinkes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PartnersUtilLinkes[] Returns an array of PartnersUtilLinkes objects
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

//    public function findOneBySomeField($value): ?PartnersUtilLinkes
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
