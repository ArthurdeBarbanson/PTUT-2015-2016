<?php

namespace SiteBundle\Forms\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateAnnonce extends AbstractType

{
    public function buildForm(FormBuilderInterface $builder, array $options)
    { $builder
        ->add('Map', TextType::class,array(
            'label' => 'Nom du maitre d\'apprentissage',
            'attr' => ['class' => 'form-control'],

        ))
        ->add('Formationmap', TextType::class,array(
                'label' =>'Formation du maitre d\'apprentissage',
            'attr' => ['class' => 'form-control'],
            ))
            ->add('Titre', TextType::class,array(
                'attr' => ['class' => 'form-control'],
            ))
            ->add('Lpconcerne', ChoiceType::class, array(
                'choices' => array('IEM' => 'LP IEM', 'METINET' => 'LP METINET'),
                        'multiple' => false,
                'attr' => ['class' => 'form-control'],

            ))
            ->add('Sujet', TextAreaType::class,array(
                'label' =>'Sujet (Description de la mission - Technologie',
                    'attr' => ['class' => 'form-control'],
                )
            )
            ->add('submit', SubmitType::class, [
                'label' => 'Poster',
                'attr' => ['class' => 'btn-primary btn-lg center-block', 'style' => "margin-top:20px"],
            ]);
    }
}