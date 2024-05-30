<?php

namespace App\Repository\TrickMedia;

use App\Entity\TrickMedia\TrickMediaImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TrickMediaImage>
 *
 * @method TrickMediaImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrickMediaImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrickMediaImage[]    findAll()
 * @method TrickMediaImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickMediaImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrickMediaImage::class);
    }

//    /**
//     * @return TrickMediaImage[] Returns an array of TrickMediaImage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TrickMediaImage
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
