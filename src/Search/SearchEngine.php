<?php


namespace App\Search;


use App\Entity\Search;
use App\Repository\AdvertRepository;
use Knp\Component\Pager\PaginatorInterface;

class SearchEngine
{

    private AdvertRepository $advertRepository;

    private PaginatorInterface $paginator;

    /**
     * SearchEngine constructor.
     * @param AdvertRepository $advertRepository
     * @param PaginatorInterface $paginator
     */
    public function __construct(AdvertRepository $advertRepository, PaginatorInterface $paginator)
    {
        $this->advertRepository = $advertRepository;
        $this->paginator = $paginator;
    }


    public function getResults(Search $searchQuery, $page = 1): SearchResult {
        $resultsQuery = $this->advertRepository->findSearchResults($searchQuery);

        $pageResult = $this->paginator->paginate(
            $resultsQuery, /* query NOT result */
            $page, /*page number*/
            6 /*limit per page*/
        );

        return new SearchResult($pageResult, $searchQuery);
    }

}
