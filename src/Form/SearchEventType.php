<?php

namespace App\Form;

use App\Entity\AvailableGames;
use App\Entity\Department;
use App\Entity\EventCategory;
use App\Entity\Platform;
use App\Entity\SearchEvent;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, ['class'=>EventCategory::class, 'choice_label'=>'categoryName', 'required'=>false, 'label'=>'Catégorie', 'attr'=>['class'=>'form-control']])
            ->add('price', ChoiceType::class, ['required'=>false, 'label'=>'Prix', 'attr'=>['class'=>'form-control'], 'choices'=>[
                "Cashprize croissant"=>'cashprize-up',
                "Prix croissant"=>"price-up",
                "Cashprize décroissant"=>'cashprize-down',
                "Prix décroissant"=>"price-down",
            ]])
            ->add('support', EntityType::class, ['required'=>false,'label'=>'Support', 'class'=>Platform::class, 'choice_label'=>'platformName','attr'=>['class'=>'form-control']])
            ->add('game', EntityType::class, ['required'=>false, 'class'=>AvailableGames::class, 'choice_label'=>'gameName', 'label'=>'Jeu', 'attr'=>['class'=>'form-control']])
            ->add('department', EntityType::class, ['required'=>false,'label'=>'Département', 'class'=>Department::class, 'choice_label'=>'departmentName','attr'=>['class'=>'form-control']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchEvent::class,
            'method'=> 'get',
            'csrf_protection' => false
        ]);
    }
}
