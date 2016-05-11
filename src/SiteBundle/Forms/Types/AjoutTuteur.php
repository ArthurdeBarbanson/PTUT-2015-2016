<?php

namespace SiteBundle\Forms\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class AjoutTuteur extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Civilite', ChoiceType::class, array(
                'choices' => array('H' => 'Monsieur', 'F' => 'Madame'),
                'label' => 'Civilité',
                'multiple' => false,
                'expanded' => true,
                'required' => true,
            ))
            ->add('Nom', TextType::class, array(
                'label' => 'Nom du tuteur',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3])
                ]
            ))
            ->add('Prenom', TextType::class, array(
                'label' => 'Prenom du tuteur',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 2])
                ]
            ))
            ->add('Tel', TextType::class, array(
                'label' => 'Telephone du tuteur',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 10, 'max' => 12])
                ]
            ))
            ->add('Email', TextType::class, array(
                'label' => 'Email du tuteur',
                'constraints' => [
                    new NotBlank(),
                    new Email()
                ]
            ))
            ->add('submit', SubmitType::class, [
                'label' => 'Poster',
                'attr' => ['class' => 'btn-primary btn-lg center-block', 'style' => "margin-top:20px"],
            ]);

    }
}