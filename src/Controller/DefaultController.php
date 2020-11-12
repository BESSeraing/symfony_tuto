<?php


namespace App\Controller;


use App\Entity\Advert;
use App\Repository\AdvertRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


// TEmpalte link https://templatemag.com/kompleet-free-multipurpose-bootstrap-template/
class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home(AdvertRepository $advertRepository) {
//        $lastThree = $advertRepository->findBy([], ['creationDate' => 'DESC'],3);
        $lastThree = $advertRepository->findWithPhotos(3);
        // On demande à Twig de faire le rendu du template (n'hésitez pas à aller voir le contenu de la methode renderView)
        $view = $this->renderView('pages/home.html.twig', ['adverts' => $lastThree]);
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
     * @Route("/view/{slug}", name="showAdvert")
     */
    public function showAdvert(Advert $advert, AdvertRepository $advertRepository) {
//        $advert = $advertRepository->findOneBySlug($slug);
        // On demande à Twig de faire le rendu du template (n'hésitez pas à aller voir le contenu de la methode renderView)
        $view = $this->renderView('pages/advert.html.twig', ['advert'=>$advert]);
        // On met ce rendu dans le corps de la réponse qu'on renvoie
        return new Response($view);
    }

    /**
     * @Route("/profile/{id<\d+>}", name="showUser")
     */
    public function showUser(int $id) {
        return new Response("<h1>User n°".$id."</h1>");
    }

    /**
     * @Route("/tag/{name}", name="showByTag")
     */
    public function tagPage($name, TagRepository $tagRepository, AdvertRepository $advertRepository) {
        $tag = $tagRepository->findOneByName($name);
        if ($tag === null) {
            throw new NotFoundHttpException("tag does not exists");
        }

        $adverts = $advertRepository->findByTag($tag);

        return $this->render('pages/tag.html.twig', ['tag' => $tag, 'adverts' => $adverts]);

    }

    /**
     * @Route("/category/{name}", name="showByCategory")
     */
    public function categoryPage($name, CategoryRepository $categoryRepository, AdvertRepository $advertRepository) {
        $category = $categoryRepository->findOneByName($name);
        if ($category === null) {
            throw new NotFoundHttpException("categoru does not exists");
        }

        $adverts = $advertRepository->findByCategory($category);

        return $this->render('pages/categories.html.twig', ['category' => $category, 'adverts' => $adverts]);

    }
    

}
