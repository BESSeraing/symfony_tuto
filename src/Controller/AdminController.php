<?php


namespace App\Controller;


use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

}