<?php


namespace App\Search;


use App\Form\SearchFormType;
use App\Form\SearchType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SearchFormGenerator
{

    private FormFactoryInterface $formFactory;

    private UrlGeneratorInterface $urlGenerator;

    /**
     * SearchFormGenerator constructor.
     * @param FormFactoryInterface $formFactory
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(FormFactoryInterface $formFactory, UrlGeneratorInterface $urlGenerator)
    {
        $this->formFactory = $formFactory;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @return FormView
     */
    public function generateForm(): FormView {
        $form = $this->formFactory->create(SearchFormType::class, null, ['action' => $this->urlGenerator->generate('search')]);
        return $form->createView();
    }

}
