<?php


namespace App\Controller;


use App\Entity\Advert;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    /**
     * @Route("/my-profile", name="myProfile")
     */
    public function myProfile() {
        return new Response("<h1>Mon compte</h1>");
    }


}
