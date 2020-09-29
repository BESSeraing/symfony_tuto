<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


// TEmpalte link https://templatemag.com/kompleet-free-multipurpose-bootstrap-template/
class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home() {
        // On demande à Twig de faire le rendu du template (n'hésitez pas à aller voir le contenu de la methode renderView)
        $view = $this->renderView('pages/home.html.twig', []);
        // On met ce rendu dans le corps de la réponse qu'on renvoie
        return new Response($view);
    }

    /**
     * @Route("/search", name="search")
     */
    public function search() {
        // On demande à Twig de faire le rendu du template (n'hésitez pas à aller voir le contenu de la methode renderView)
        $view = $this->renderView('pages/search.html.twig', []);
        // On met ce rendu dans le corps de la réponse qu'on renvoie
        return new Response($view);
    }

    /**
     * @Route("/view/{id<\d+>}", name="showAdvert")
     */
    public function showAdvert(int $id) {
        // On demande à Twig de faire le rendu du template (n'hésitez pas à aller voir le contenu de la methode renderView)
        $view = $this->renderView('pages/advert.html.twig', []);
        // On met ce rendu dans le corps de la réponse qu'on renvoie
        return new Response($view);
    }

    /**
     * @Route("/profile/{id<\d+>}", name="showUser")
     */
    public function showUser(int $id) {
        return new Response("<h1>User n°".$id."</h1>");
    }
    

}
