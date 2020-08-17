<?php

namespace App\Form;

use App\Entity\AvailableGames;
use App\Entity\EventCategory;
use App\Entity\Events;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label'=>"Nom de l'évènement",'attr'=>['class'=>'form-control']])
            ->add('websiteLink', TextType::class, ['label'=>"Lien du site web",'attr'=>['class'=>'form-control']])
            ->add('place', TextType::class, ['label'=>"Lieu de l'évènement",'attr'=>['class'=>'form-control']])
            ->add('launchDate', DateType::class, ['label'=>"Date de lancement",'widget'=>'single_text', 'attr'=>['class'=>'form-control']])
            ->add('stopDate', DateType::class, ['label'=>"Date de fin",'widget'=>'single_text', 'attr'=>['class'=>'form-control']])
            ->add('shortDesc', TextareaType::class, ['label'=>"Description courte",'attr'=>['class'=>'form-control', 'cols'=>'40', 'rows'=>'5']])
            ->add('longDesc', TextareaType::class, ['label'=>"Description longue",'attr'=>['class'=>'form-control', 'cols'=>'40', 'rows'=>'20']])
            ->add('address', TextType::class, ['label'=>"Adresse",'attr'=>['class'=>'form-control']])
            ->add('ticketNumber', IntegerType::class, ['label'=>"Nombre de tickets",'attr'=>['class'=>'form-control']])
            ->add('price', IntegerType::class, ['label'=>"Prix",'attr'=>['class'=>'form-control','step'=>'0.01','min'=>'0.00', 'max'=>'10000.00']])
            ->add('availableGames', EntityType::class,['label'=>"Jeux disponibles",'class'=>AvailableGames::class, 'choice_label'=>'gameName','multiple'=>true,'attr'=>['class'=>'form-control']])
            ->add('category', EntityType::class, ['label'=>"Catégorie",'attr'=>['class'=>'form-control'],'class'=>EventCategory::class, 'choice_label'=>'categoryName'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Events::class,
        ]);
    }
}
