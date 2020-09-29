<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class DefaultController
{

    /**
     * @Route("/", name="home")
     */
    public function home() {
        return new Response("<h1>Home</h1>");
    }

    /**
     * @Route("/search", name="search")
     */
    public function search() {
        return new Response("<h1>Recherche</h1>");
    }

    /**
     * @Route("/view/{id<\d+>}", name="showAdvert")
     */
    public function showAdvert(int $id) {
        return new Response("<h1>Annonce n°".$id."</h1>");
    }

    /**
     * @Route("/profile/{id<\d+>}", name="showUser")
     */
    public function showUser(int $id) {
        return new Response("<h1>User n°".$id."</h1>");
    }
    

}
