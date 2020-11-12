<?php

namespace App\Repository;

use App\Entity\Advert;
use App\Entity\Category;
use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Advert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Advert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Advert[]    findAll()
 * @method Advert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdvertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Advert::class);
    }

    public function findByTag(Tag $tag) {
        $qb = $this->createQueryBuilder('a');

        $qb ->leftJoin('a.tags', 'tags')
            ->where('tags in (:tagList)')
            ->setParameter('tagList', [$tag])
            ;
        return $qb->getQuery()->getResult();
    }

    public function findWithPhotos($limit) {
        $qb = $this->createQueryBuilder('a');
        $qb
            ->groupBy('a.id')
            ->orderBy('a.creationDate', 'DESC')
            ->setMaxResults($limit)
        ;

        $this->leftJoinPhotos($qb);

        return $qb->getQuery()->getResult();

    }

    public function findOneWithPhotos($limit): Advert {
        $qb = $this->createQueryBuilder('a');
        $qb
            ->groupBy('a.id')
            ->orderBy('a.creationDate', 'DESC')
            ->setMaxResults($limit)
        ;

        $this->leftJoinPhotos($qb);

        return $qb->getQuery()->getOneOrNullResult();

    }

    public function findByCategory(Category $category)
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.category = :category')
            ->setParameter('category', $category);

        $this->leftJoinPhotos($qb);

        return $qb->getQuery()->getResult();

    }

    private function leftJoinPhotos(QueryBuilder $qb): void {
        $qb->leftJoin('a.gallery', 'gallery')
            ->addSelect('gallery')
            ->leftJoin('gallery.photos', 'photos')
            ->addSelect('photos')
        ;
    }

    // /**
    //  * @return Advert[] Returns an array of Advert objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Advert
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

}
