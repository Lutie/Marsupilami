<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MarsupilamiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de votre Marsupilami',
            ])
            ->add('rawPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Votre mot de passe'],
                'second_options' => ['label' => 'Veuillez réécrire votre mot de passe'],
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
