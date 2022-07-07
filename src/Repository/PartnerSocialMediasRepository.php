<?php

namespace App\Repository;

use App\Entity\PartnerSocialMedias;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PartnerSocialMedias>
 *
 * @method PartnerSocialMedias|null find($id, $lockMode = null, $lockVersion = null)
 * @method PartnerSocialMedias|null findOneBy(array $criteria, array $orderBy = null)
 * @method PartnerSocialMedias[]    findAll()
 * @method PartnerSocialMedias[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartnerSocialMediasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PartnerSocialMedias::class);
    }

    public function add(PartnerSocialMedias $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PartnerSocialMedias $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PartnerSocialMedias[] Returns an array of PartnerSocialMedias objects
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

//    public function findOneBySomeField($value): ?PartnerSocialMedias
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
