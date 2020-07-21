<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, ['label'=>'Adresse Email', 'attr'=>['class'=>'form-control']])
            ->add('roles', ChoiceType::class, ['label'=>'Rôles utilisateur', 'choices'=> [
                'ROLE_USER'=> 'Utilisateur',
                'ROLE_ADMIN' => 'Administrateur',
                'ROLE_BUSINESS' => 'Partenaire/Organisateur'
            ],
            'attr'=>['class'=>'form-control'],
            'multiple'=>true
            ])
            ->add('password', PasswordType::class, ['label'=>'Mot de passe','attr'=>['class'=>'form-control']])
            ->add('firstName', TextType::class, ['label'=>'Prénom', 'attr'=>['class'=>'form-control']])
            ->add('lastName', TextType::class, ['label'=>'Nom', 'attr'=>['class'=>'form-control']])
            ->add('Company', TextType::class, ['label'=>'Compagnie', 'attr'=>['class'=>'form-control']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
