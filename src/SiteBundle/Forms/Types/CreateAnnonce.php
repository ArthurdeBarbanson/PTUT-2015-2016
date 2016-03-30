<?php

namespace SiteBundle\Forms\Types;

use Symfony\Component\Form\AbstractType;
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

        ))
        ->add('Formationmap', TextType::class,array(
                'label' =>'Formation du maitre d\'apprentissage',
            ))
            ->add('Titre', TextType::class,array(

            ))
            ->add('Lpconcerne', 'choice', array(
                'choices' => array('IEM' => 'LP IEM', 'METINET' => 'LP METINET'),
                        'multiple' => false
            ))
            ->add('Sujet', TextAreaType::class,array(
                'label' =>'Sujet (Description de la mission - Technologie',
                )
            )
            ->add('submit', SubmitType::class, [
                'label' => 'Poster',
                'attr' => ['class' => 'btn-primary btn-lg'],
            ]);
    }
}