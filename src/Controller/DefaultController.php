<?php


namespace App\Controller;


use App\Entity\Advert;
use App\Entity\Answer;
use App\Entity\Question;
use App\Form\AnswerType;
use App\Form\QuestionType;
use App\Repository\AdvertRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
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
        $lastThree = $advertRepository->findWithPhotos(9);
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
    public function showAdvert(Advert $advert, Request $request, EntityManagerInterface $entityManager) {

        $question = new Question();
        $question->setAdvert($advert);
        $questionForm = $this->createForm(QuestionType::class, $question);
        $questionForm->handleRequest($request);
        if ($questionForm->isSubmitted() && $questionForm->isValid()) {
            $entityManager->persist($question);
            $entityManager->flush();
            return $this->redirectToRoute('showAdvert', ['slug'=> $advert->getSlug()]);
        }

        $answerForm = $this->createForm(AnswerType::class, null, ['action' => $this->generateUrl('postAnswer')]);

        $view = $this->renderView('pages/advert.html.twig', ['advert'=>$advert,
            'form' => $questionForm->createView(),
            'answerForm' => $answerForm->createView()
            ]);
        return new Response($view);
    }

    /**
     * @Route("/post/answer", name="postAnswer", condition="request.isXmlHttpRequest()", methods={"POST"})
     */
    public function postAnswer(Request $request, EntityManagerInterface $em) {
        $answer = new Answer();
        $answerForm = $this->createForm(AnswerType::class, $answer);
        $answerForm->handleRequest($request);
        if ($this->getUser() !== $answer->getQuestion()->getAdvert()->getCreatedBy()) {
            return new AccessDeniedException("you're not the OP");
        }

        if ($answerForm->isSubmitted() && $answerForm->isValid()) {
            $em->persist($answer);
            $em->flush();
        }

        return $this->render('pages/element/answer.html.twig', ['answer' => $answer]);

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
     * @Route("/category/{name}/{page<\d+>}", name="showByCategory")
     */
    public function categoryPage($name, $page = 1, CategoryRepository $categoryRepository, AdvertRepository $advertRepository, PaginatorInterface $paginator, Request $request) {
        $category = $categoryRepository->findOneByName($name);
        if ($category === null) {
            throw new NotFoundHttpException("category does not exists");
        }

        $query = $advertRepository->findByCategoryQb($category);

        $options = [];
        if ($request->query->get('sort') !== null) {
            $options['defaultSortFieldName'] = $request->query->get('sort');
            $options['defaultSortDirection'] = $request->query->get('direction');
        }

        $page = $paginator->paginate(
            $query, /* query NOT result */
            $page, /*page number*/
            2 /*limit per page*/,
            $options
        );

        return $this->render('pages/categories.html.twig', ['category' => $category, 'advertsPage' => $page]);

    }
    

}
