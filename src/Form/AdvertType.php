<?php

namespace App\Form;

use App\Entity\Advert;
use App\Entity\Category;
use App\Entity\Constants\FrameSize;
use App\Entity\Constants\FrameType;
use App\Entity\Constants\Material;
use App\Entity\Constants\WheelSize;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        // Pas besoin du champ slug il est autogénéré sur base du title tout comme creationDate
        $builder
            ->add('title')
            ->add('price')
            ->add('description')
            ->add('wheelSize', ChoiceType::class, ['choices' => WheelSize::formValues()])
            ->add('frameSize', ChoiceType::class, ['choices' => FrameSize::formValues()])
            ->add('fork')
            ->add('material', ChoiceType::class, ['choices' => Material::formValues()])
            ->add('frameType', ChoiceType::class, ['choices' => FrameType::formValues()])
            ->add('year', DateType::class, ['years' => self::getYears()])
            ->add('category', EntityType::class, ['class' => Category::class])
            ->add('tags', EntityType::class, ['class' => Tag::class, 'multiple' => true, 'expanded' => true, 'choice_label' => 'name'])
            ->add('gallery', PhotoGalleryType::class)
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Advert::class,
        ]);
    }

    private static function getYears(): array
    {
        $years = [];
        $currentYear = date('Y');
        $numberOfYears = 20;
        for($i=0; $i < $numberOfYears; $i++) {
            $years[] = $currentYear - $i;
        }

        return $years;
    }
}
