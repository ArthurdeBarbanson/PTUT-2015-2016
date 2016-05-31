<?php

namespace SiteBundle\Forms\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateAnnonce extends AbstractType

{
    public function buildForm(FormBuilderInterface $builder, array $options)
    { $builder
           ->add('Titre', TextType::class,array(
               'constraints' => [
                   new NotBlank(),
                   new Length(['min' => 3])
               ]
            ))
            ->add('Lpconcerne', ChoiceType::class, array(
                'label' => 'Lp concerné',
                'choices' => array('IEM' => 'IEM', 'METINET' => 'METINET'),
                'multiple' => false,
                'expanded'=>true,
                'required' => true,

            ))
            ->add('Sujet', TextAreaType::class,array(
                'label' =>'Sujet (Description de la mission - Technologie)',
                    'constraints' => [
                        new NotBlank(),
                        new Length(['min' => 50])
                    ]
                )
            )
            ->add('submit', SubmitType::class, [
                'label' => 'Poster',
                'attr' => ['class' => 'btn-primary btn-lg  col-lg-1 col-lg-offset-4', 'style' => "margin-top:20px"],

            ])
            ->add('cancel', SubmitType::class, array(
              'label' => 'Annulez',
                      'attr' => ['formnovalidate' => 'formnovalidate','class' => 'btn-default btn-lg col-lg-1 col-lg-offset-1', 'style' => "margin-top:20px"],

    ));
    }
}