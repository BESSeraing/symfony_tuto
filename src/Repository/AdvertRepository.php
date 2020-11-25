<?php

namespace App\Repository;

use App\Entity\Advert;
use App\Entity\Category;
use App\Entity\Search;
use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query;
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

    public function findByCategoryPaged(Category $category, int $page, int $pageLength)
    {
        $offset = (($page -1 ) * $pageLength) ;

        $qb = $this->createQueryBuilder('a')
            ->where('a.category = :category')
            ->setParameter('category', $category)
            ->setMaxResults($pageLength)
            ->setFirstResult($offset)
        ;

        $this->leftJoinPhotos($qb);

        return $qb->getQuery()->getResult();

    }

    /**
     * @param $category
     * @return \Doctrine\ORM\Query
     */
    public function findByCategoryQb($category): Query
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.category = :category')
            ->setParameter('category', $category)
        ;

        $this->leftJoinPhotos($qb);

        return $qb->getQuery();
    }

    private function leftJoinPhotos(QueryBuilder $qb): void {
        $qb->leftJoin('a.gallery', 'gallery')
            ->addSelect('gallery')
            ->leftJoin('gallery.photos', 'photos')
            ->addSelect('photos')
        ;
    }

    // Search

    public function findSearchResults(Search $search) {
        $qb = $this->createQueryBuilder('a');
        if($search->getKeyword() !== null) {
            $this->keywordCriteria($qb, $search->getKeyword());
        }
        if ($search->getCategories() !== null && count($search->getCategories())) {
            $this->categroryCriteria($qb, $search->getCategories());
        }
        if ($search->getTags() !== null && count($search->getTags())) {
            $this->tagCriteria($qb, $search->getTags());
        }
        if ($search->getFrameSizes() !== null && count($search->getFrameSizes())) {
            $this->frameSizeCriteria($qb, $search->getFrameSizes());
        }
        if ($search->getFrameTypes() !== null && count($search->getFrameTypes())) {
            $this->frameTypeCriteria($qb, $search->getFrameTypes());
        }
        if ($search->getPriceMax() !== null) {
            $this->priceMaxCriteria($qb, $search->getPriceMax());
        }
        if ($search->getPriceMin() !== null) {
            $this->priceMinCriteria($qb, $search->getPriceMin());
        }

        $this->leftJoinPhotos($qb);

        return $qb->getQuery();
    }

    private function priceMaxCriteria(QueryBuilder $qb, float $priceMax): void {
        $qb ->andWhere('a.price <= :priceMax')
            ->setParameter('priceMax', $priceMax)
        ;
    }

    private function priceMinCriteria(QueryBuilder $qb, float $priceMin): void {
        $qb ->andWhere('a.price >= :priceMin')
            ->setParameter('priceMin', $priceMin)
        ;
    }

    private function frameTypeCriteria(QueryBuilder $qb, array $frameTypes): void {
        $qb ->andWhere('a.frameType in (:frametypes)')
            ->setParameter('frametypes', $frameTypes)
        ;
    }

    private function frameSizeCriteria(QueryBuilder $qb, array $frameSizes): void {
        $qb ->andWhere('a.frameSize in (:framesizes)')
            ->setParameter('framesizes', $frameSizes)
        ;
    }
    private function tagCriteria(QueryBuilder $qb, ArrayCollection $tags): void {
        $qb->leftJoin('a.tags', 't')
            ->andWhere('t in (:tags)')
            ->setParameter('tags', $tags)
        ;
    }

    private function categroryCriteria(QueryBuilder $qb, ArrayCollection $categories): void {
        $qb->leftJoin('a.category', 'c')
            ->andWhere('c in (:categories)')
            ->setParameter('categories', $categories)
        ;
    }

    private function keywordCriteria(QueryBuilder $qb, string $keyword): void {
        $qb ->andWhere('a.title like :keyword')
            ->setParameter('keyword', "%".$keyword."%");
        ;
    }
    // End Search

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
