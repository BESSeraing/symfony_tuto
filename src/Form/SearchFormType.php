<?php

namespace App\Form;

use App\Entity\Constants\FrameSize;
use App\Entity\Constants\FrameType;
use App\Entity\Search;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SearchFormType
 * @package App\Form
 * Si le nom est SearchType il y aura des soucis.
 */
class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('keyword')
            ->add('frameTypes', ChoiceType::class, ['expanded' => true, 'multiple' => true, 'choices' => FrameType::formValues()])
            ->add('frameSizes', ChoiceType::class, ['expanded' => true,'multiple' => true, 'choices' => FrameSize::formValues()])
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
