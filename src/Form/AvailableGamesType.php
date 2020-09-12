<?php

namespace App\Form;

use App\Entity\AvailableGames;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AvailableGamesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gameName', TextType::class, ['label'=>'Nom du jeu', 'attr'=>['class'=>'form-control']])
            ->add('gameUrl', TextType::class, ['label'=>'Lien du site officiel du jeu', 'attr'=>['class'=>'form-control']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AvailableGames::class,
        ]);
    }
}
