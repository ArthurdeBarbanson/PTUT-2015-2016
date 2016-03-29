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
        ->
        add('Maitre de Stage', TextType::class)
            ->add('Formation du maitre du stage', TextType::class)
            ->add('Titre', TextType::class)
            ->add('Lp concerné', HiddenType::class, array(
                'choices' => array('IEM' => 'LP IEM', 'METINET' => 'LP METINET'),
                'expanded' => true,
                'multiple' => false
            ))
            ->add('Sujet (Description de la mission - Technologie', TextAreaType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'Poster',
                'attr' => ['class' => 'btn-primary btn-lg'],
            ]);
    }
}