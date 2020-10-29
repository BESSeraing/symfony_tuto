<?php


namespace App\Controller;


use App\Entity\Advert;
use App\Entity\Category;
use App\Entity\Photo;
use App\Entity\PhotoGallery;
use App\Form\AdvertType;
use App\Repository\CategoryRepository;
use App\Service\AdvertPhotoUploader;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller
 * @Route("admin/")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("category/create", name="createCategory")
     */
    public function createCategory(EntityManagerInterface $entityManager) {
        $category = new Category();
        $category->setName("Enduro");

        $entityManager->persist($category);
        $entityManager->flush();

        return new Response("category created</body>");
    }

    /**
     * @Route("category", name="showCategories")
     */
    public function listCategory(CategoryRepository $categoryRepository) {
        $categories = $categoryRepository->findAll();
//        $enduro = $categoryRepository->find(1);
//        $categories = [$enduro];
        return $this->render("admin/list.html.twig", ['categories' => $categories]);
    }

    /**
     * @Route("advert/create", name="createAdvert")
    */
    public function createAdvert(Request $request, EntityManagerInterface $entityManager, AdvertPhotoUploader $advertPhotoUploader) {
        $advert = new Advert();
        $advert->setYear(\DateTime::createFromFormat('Y', date('Y')));

        $gallery = new PhotoGallery();
        $advert->setGallery($gallery);

        $form = $this->createForm(AdvertType::class, $advert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $advertPhotoUploader->uploadFilesFromForm($form->get('gallery'));
            $entityManager->persist($advert);
            $entityManager->flush();

            return $this->redirectToRoute("showAdvert", ["slug" => $advert->getSlug()]);
        }


        return $this->render("admin/edit-advert.html.twig", ['advertForm' => $form->createView()]);
    }

    /**
     * @Route("advert/edit/{id}", name="editAdvert")
    */
    public function editAdvert(Advert $advert, Request $request, EntityManagerInterface $entityManager, AdvertPhotoUploader $advertPhotoUploader) {

        $form = $this->createForm(AdvertType::class, $advert);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $advertPhotoUploader->uploadFilesFromForm($form->get('gallery'));
            $entityManager->persist($advert);

            foreach ($advert->getGallery()->getPhotos() as $photo) {
                $photo->setGallery($advert->getGallery());
            }

            $entityManager->flush();

            return $this->redirectToRoute("showAdvert", ["slug" => $advert->getSlug()]);
        }


        return $this->render("admin/edit-advert.html.twig", ['advertForm' => $form->createView()]);
    }

}
