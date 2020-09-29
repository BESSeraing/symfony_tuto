<?php


namespace App\Controller;


use App\Entity\Advert;
use App\Entity\AdvertPicture;
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

        $pictures = [
            new AdvertPicture('53475214_1016563661866620_7896463576045453312_n.jpg'),
            new AdvertPicture('53489175_1016563665199953_6176948323597942784_n.jpg'),
            new AdvertPicture('Screenshot_2020-09-29 Facebook.jpg')
        ];
        $adverts = [
            new Advert(1, 'Scott scale 930', "1250.544", "lorem", "XC", $pictures),
            new Advert(2, 'Canondale Scalpel 2', "2750", "lorem", "XC", $pictures),
            new Advert(3, 'fdhgsbewgf q', "1300", "lorem", "DH", $pictures),
        ];

        // On demande à Twig de faire le rendu du template (n'hésitez pas à aller voir le contenu de la methode renderView)
        $view = $this->renderView('pages/home.html.twig', ['adverts' => $adverts]);
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

        $pictures = [
            new AdvertPicture('53475214_1016563661866620_7896463576045453312_n.jpg'),
            new AdvertPicture('53489175_1016563665199953_6176948323597942784_n.jpg'),
            new AdvertPicture('Screenshot_2020-09-29 Facebook.jpg')
        ];

        $advert = new Advert(1, 'Scott scale 910', "1250.544", "lorem", "XC", $pictures);
        // On demande à Twig de faire le rendu du template (n'hésitez pas à aller voir le contenu de la methode renderView)
        $view = $this->renderView('pages/advert.html.twig', ['advert' => $advert]);
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
