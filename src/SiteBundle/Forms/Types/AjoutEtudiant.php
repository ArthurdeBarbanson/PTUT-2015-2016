<?php

namespace SiteBundle\Forms\Types;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class AjoutEtudiant extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('Email', EmailType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('Lpconcerne', ChoiceType::class, array(
                'label' => 'Type de licence',
                'choices' => array('IEM' => 'IEM', 'METINET' => 'METINET', 'Aucune' => null),
                'multiple' => false,
                'expanded' => true,
                'preferred_choices' => array('Aucune'),
            ))
            ->add('promo', EntityType::class, [
                'label' => 'Promotion',
                'choices' => $options['data'],
                'class' => 'SiteBundle\Entity\Session',
                'choice_label' => 'anneeScolaire',
            ])
            ->add('submit', SubmitType::class, ['label' => "Ajouter", 'attr' => ['class' => 'btn-primary']]);
    }
}
