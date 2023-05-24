<?php

namespace App\Form;

use App\Entity\Feedback;
use App\Entity\RatingQuestion;
use App\Entity\Rating;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RatingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('score', NumberType::class)
            ->add('feedback', EntityType::class, [
                'class' => Feedback::class
            ])
            ->add('ratingQuestion', EntityType::class, [
                'class' => RatingQuestion::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rating::class,
        ]);
    }
}
