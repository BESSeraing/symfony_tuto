<?php


namespace App\Service\Menu;


use App\Repository\CategoryRepository;
use App\Service\Menu\MenuElementModel;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Security;

class Menu
{

    private CategoryRepository $categoryRepository;
    private UrlGeneratorInterface $urlGenerator;
    private Security $security;

    /**
     * Menu constructor.
     * @param CategoryRepository $categoryRepository
     * @param UrlGeneratorInterface $urlGenerator
     * @param Security $tokenStorage
     */
    public function __construct(CategoryRepository $categoryRepository, UrlGeneratorInterface $urlGenerator, Security $security)
    {
        $this->categoryRepository = $categoryRepository;
        $this->urlGenerator = $urlGenerator;
        $this->security = $security;
    }


    public function getMenu(): array {
        $menu = [];

        // Partie categories
        $mainCategories = new MenuElementModel();
        $mainCategories->setTitle('Categories');

        $categories = $this->categoryRepository->findAll();
        $menu[] = $mainCategories;
        foreach ($categories as $category) {
            $menuCategory = new MenuElementModel();
            $menuCategory->setTitle($category->getName());
            $menuCategory->setLink($this->urlGenerator->generate('showByCategory', ['name' => $category->getName()]));
            $mainCategories->addChild($menuCategory);
        }

        // Partie user
        $user = $this->security->getUser();
        if ($user === null){
            $menuLogin = new MenuElementModel();
            $menuLogin->setTitle("Sign in");
            $menuLogin->setLink($this->urlGenerator->generate('app_login'));
            $menu[] = $menuLogin;

            $menuRegister = new MenuElementModel();
            $menuRegister->setTitle("Créer un compte");
            $menuRegister->setLink($this->urlGenerator->generate('register'));
            $menu[] = $menuRegister;
        } else {
            $menuUser = new MenuElementModel();
            $menuUser->setTitle("Mon Compte");

            $menuLogout = new MenuElementModel();
            $menuLogout->setTitle('Se déconnecter');
            $menuLogout->setLink($this->urlGenerator->generate('app_logout'));

            $menuUser->addChild($menuLogout);

            $menu[] = $menuUser;
        }

        return $menu;
    }

}
