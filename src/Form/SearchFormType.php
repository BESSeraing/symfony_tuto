<?php

namespace App\Form;

use App\Entity\Search;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('keyword')
            ->add('frameTypes')
            ->add('frameSizes')
            ->add('priceMin')
            ->add('priceMax')
            ->add('categories')
            ->add('tags')
            ->add('search', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
}
