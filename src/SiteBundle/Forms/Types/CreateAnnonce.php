<?php

namespace SiteBundle\Forms\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateAnnonce extends AbstractType

{
    public function buildForm(FormBuilderInterface $builder, array $options)
    { $builder
           ->add('Titre', TextType::class,array(

            ))
            ->add('Lpconcerne', ChoiceType::class, array(
                'choices' => array('IEM' => 'LP IEM', 'METINET' => 'LP METINET'),
                'multiple' => false,
                'expanded'=>true,


            ))
            ->add('Sujet', TextAreaType::class,array(
                'label' =>'Sujet (Description de la mission - Technologie',

                )
            )
            ->add('submit', SubmitType::class, [
                'label' => 'Poster',
                'attr' => ['class' => 'btn-primary btn-lg center-block', 'style' => "margin-top:20px"],
            ]);
    }
}