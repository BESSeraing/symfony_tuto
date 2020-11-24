<?php


namespace App\Search;


use App\Entity\Advert;
use App\Entity\Search;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\Component\Pager\Pagination\PaginationInterface;

class SearchResult
{

    private PaginationInterface $results;

    private Search $searchQuery;

    /**
     * SearchResult constructor.
     * @param Advert[]|ArrayCollection $results
     * @param Search $searchQuery
     */
    public function __construct(PaginationInterface $results = null, Search $searchQuery = null)
    {
        if ($results !== null) {
            $this->results = $results;
        }
        if ($searchQuery !== null) {
            $this->searchQuery = $searchQuery;
        }
    }

    /**
     * @return Advert[]|ArrayCollection|PaginationInterface
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @param Advert[]|ArrayCollection|PaginationInterface $results
     */
    public function setResults($results): void
    {
        $this->results = $results;
    }


    /**
     * @return Search
     */
    public function getSearchQuery(): Search
    {
        return $this->searchQuery;
    }

    /**
     * @param Search $searchQuery
     */
    public function setSearchQuery(Search $searchQuery): void
    {
        $this->searchQuery = $searchQuery;
    }



}
