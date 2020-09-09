<?php

namespace App\Form;

use App\Entity\Events;
use App\Entity\EventCategory;
use App\Entity\AvailableGames;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EventsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label'=>"Nom de l'évènement",'attr'=>['class'=>'form-control']])
            ->add('websiteLink', TextType::class, ['label'=>"Lien du site web",'attr'=>['class'=>'form-control']])
            ->add('place', TextType::class, ['label'=>"Lieu de l'évènement",'attr'=>['class'=>'form-control']])
            ->add('launchDate', DateTimeType::class, ['label'=>"Date de lancement",'widget'=>'single_text', 'attr'=>['class'=>'form-control']])
            ->add('stopDate', DateTimeType::class, ['label'=>"Date de fin",'widget'=>'single_text', 'attr'=>['class'=>'form-control']])
            ->add('shortDesc', TextareaType::class, ['label'=>"Description courte",'attr'=>['class'=>'form-control', 'cols'=>'40', 'rows'=>'5']])
            ->add('longDesc', TextareaType::class, ['label'=>"Description longue",'attr'=>['class'=>'form-control', 'cols'=>'40', 'rows'=>'20']])
            ->add('address', TextType::class, ['label'=>"Adresse",'attr'=>['class'=>'form-control']])
            ->add('city', TextType::class, ['label'=>"Ville",'attr'=>['class'=>'form-control']])
            ->add('cp', TextType::class, ['label'=>"Code Postal",'attr'=>['class'=>'form-control']])
            ->add('department', TextType::class, ['label'=>"Département",'attr'=>['class'=>'form-control']])
            ->add('ticketNumber', IntegerType::class, ['label'=>"Nombre de places",'attr'=>['class'=>'form-control']])
            ->add('price', IntegerType::class, ['label'=>"Prix d'entrée",'attr'=>['class'=>'form-control','step'=>'0.01','min'=>'0.00', 'max'=>'10000.00']])
            ->add('cashprize', IntegerType::class, ['label'=>"Cashprize",'attr'=>['class'=>'form-control','step'=>'0.01','min'=>'0.00', 'max'=>'10000.00']])
            ->add('support', ChoiceType::class, ['label'=>'Support', 'attr'=>['class'=>''],
                    'choices'=>[
                        'PC'=>'PC',
                        'Console'=>'CONSOLE'
                    ],
                    'multiple'=>true,
                    'expanded'=>true
            ])
            ->add('availableGames', EntityType::class,['label'=>"Jeux disponibles",'class'=>AvailableGames::class, 'choice_label'=>'gameName','multiple'=>true,'attr'=>['class'=>'form-control']])
            ->add('category', EntityType::class, ['label'=>"Catégorie",'attr'=>['class'=>'form-control'],'class'=>EventCategory::class, 'choice_label'=>'categoryName'])
            ->add('fbUrl', TextType::class, ['mapped'=>false, 'attr'=>['class'=>'form-control ml-3 fbInput', 'disabled'=>'true','placeholder'=>"Entrez votre lien ici"]])
            ->add('twUrl', TextType::class, ['mapped'=>false, 'attr'=>['class'=>'form-control ml-3 twInput', 'disabled'=>'true','placeholder'=>"Entrez votre lien ici"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Events::class,
        ]);
    }
}
