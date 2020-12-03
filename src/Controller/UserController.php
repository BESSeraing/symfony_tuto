<?php


namespace App\Controller;


use App\Entity\Advert;
use App\Flash\FlashType;
use App\Form\AdvertType;
use App\Form\UserPasswordType;
use App\Form\UserType;
use App\Repository\AdvertRepository;
use App\Repository\UserRepository;
use App\Security\ResetPasswordService;
use App\Service\AdvertPhotoUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController
 * @package App\Controller
 * @Route("/account")
 */
class UserController extends AbstractController
{

    /**
     * @Route("/my-profile", name="myProfile")
     */
    public function myProfile() {
        return new Response("<h1>Mon compte</h1>");
    }

    /**
     * @Route("/create-advert", name="accountCreateAdvert")
     */
    public function createAdvert(Request $request, EntityManagerInterface $em, AdvertPhotoUploader $advertPhotoUploader) {
        $advert = new Advert();
        $advert->setYear(new \DateTime());
        $form = $this->createForm(AdvertType::class, $advert);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $advertPhotoUploader->uploadFilesFromForm($form->get('gallery'));
            $em->persist($advert);
            $em->flush();
            return $this->redirectToRoute('showAdvert', ['slug' => $advert->getSlug()]);
        }

        return $this->render("pages/account/create-advert.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @Route("/edit-advert/{id}", name="accountEditAdvert")
     */
    public function editAdvert(Advert $advert, Request $request, EntityManagerInterface $em, AdvertPhotoUploader $advertPhotoUploader) {
        if ($advert->getCreatedBy() !== $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $form = $this->createForm(AdvertType::class, $advert);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $advertPhotoUploader->uploadFilesFromForm($form->get('gallery'));
            $em->persist($advert);
            $em->flush();
            return $this->redirectToRoute('showAdvert', ['slug' => $advert->getSlug()]);
        }

        return $this->render("pages/account/create-advert.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @Route("/my-adverts", name="accountMyAdvert")
     */
    public function myAdverts(AdvertRepository $advertRepository) {
        $adverts = $advertRepository->findByCreatedBy($this->getUser());

        return $this->render("pages/account/my-adverts.html.twig", ['adverts' => $adverts]);
    }

    /**
     * @Route("/my-account", name="myAccount")
     */
    public function myAccount(EntityManagerInterface $entityManager, Request $request) {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(FlashType::SUCCESS, "Your email has been updated");
        }

        return $this->render("pages/account/my-account.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @Route("/my-password", name="myPassword")
     */
    public function myPassword(Request $request, ResetPasswordService $resetPasswordService) {
        $user = $this->getUser();

        $form = $this->createForm(UserPasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $resetPasswordService->savePassword($user);
        }

        return $this->render("pages/account/my-account.html.twig", ['form' => $form->createView()]);
    }




}
