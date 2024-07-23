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


}
