<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de votre Marsupilami',
            ])
            ->add('birthdate', DateType::class, [
                'label' => 'Date de naissance du Marsupilami',
                'widget' => 'single_text',
            ])
            ->add('family', TextType::class, [
                'label' => 'Quelle est sa Famille ?',
            ])
            ->add('race', TextType::class, [
                'label' => 'Quelle est sa Race',
            ])
            ->add('food', TextType::class, [
                'label' => 'Sa nourriture préférée',
            ]);
    }
}
