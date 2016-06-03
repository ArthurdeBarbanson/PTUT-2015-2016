<?php

namespace SiteBundle\Forms\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ModifierEtudiant extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Civilite', ChoiceType::class, array(
                'choices' => array(' Monsieur ' => 'M', 'Madame ' => 'F'),
                'label' => 'Civilité',
                'multiple' => false,
                'expanded' => true,
                'required' => true,
            ))
            ->add('Prenom', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('Nom', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('Telephone', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('DateNaissance', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('NumeroCiel2', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('Email', EmailType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('Nationalite', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('VilleNaissance', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('Commune', TextType::class)
            ->add('Adresse', TextType::class)
            ->add('CodePostal', IntegerType::class)
            ->add('verif_mdp', PasswordType::class, [
                'required' => false
            ])
            ->add('newPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identique.',
                'required' => false,
                'first_options' => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Répéter mot de passe'),
            ))
            ->add('submit', SubmitType::class, ['label' => "Enregistrer", 'attr' => ['class' => 'btn-primary']]);
    }
}
