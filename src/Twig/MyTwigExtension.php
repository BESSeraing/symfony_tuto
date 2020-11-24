<?php


namespace App\Twig;


use App\Service\Menu\Menu;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MyTwigExtension extends AbstractExtension
{

    private Menu $menuService;

    /**
     * MyTwigExtension constructor.
     * @param Menu $menuService
     */
    public function __construct(Menu $menuService)
    {
        $this->menuService = $menuService;
    }


    public function getFunctions()
    {
        return [
            new TwigFunction('getMenu', [$this->menuService, 'getMenu'])
        ];
    }

}
