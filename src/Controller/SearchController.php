<?php


namespace App\Controller;


use App\Entity\Search;
use App\Form\SearchFormType;
use App\Search\SearchEngine;
use App\Search\SearchResult;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{

    /**
     * @param Request $request
     * @Route("/search/{page}", name="search")
     */
    public function search(int $page = 1, Request $request, SearchEngine $searchEngine) {
        $searchQuery = new Search();
        $form = $this->createForm(SearchFormType::class, $searchQuery);
        $form->handleRequest($request);
        $result = new SearchResult(null, null);
        if ($form->isSubmitted() && $form->isValid()) {
            $result = $searchEngine->getResults($searchQuery, $page);
        }

        return $this->render('pages/search.html.twig', ['result' => $result, 'form' => $form->createView()]);
    }

}
