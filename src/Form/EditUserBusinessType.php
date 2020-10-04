<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserBusinessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, ['label'=>'Adresse Email','attr'=>['class'=>'form-control']])
            ->add('oldPassword', PasswordType::class, ['required'=>false,'label'=>'Mot de passe actuel','mapped'=>false, 'attr'=>['class'=>'form-control']])
            ->add('newPassword', PasswordType::class, ['required'=>false,'label'=>'Nouveau mot de passe','mapped'=>false, 'attr'=>['class'=>'form-control']])
            ->add('firstName', TextType::class, ['label'=>'Prénom','attr'=>['class'=>'form-control']])
            ->add('lastName', TextType::class, ['label'=>'Nom','attr'=>['class'=>'form-control']])
            ->add('company', TextType::class, ['required'=>false, 'label'=>'Société','attr'=>['class'=>'form-control']])
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
