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
        ->add('Formation_du maitre_du_stage', TextType::class,array(
                'label' =>'Formation du maitre du stage',
            ))
            ->add('Titre', TextType::class,array(

            ))
            ->add('Lp_concerné', HiddenType::class, array(
                'choices' => array('IEM' => 'LP IEM', 'METINET' => 'LP METINET'),
                'expanded' => true,
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