<?php

namespace SiteBundle\Forms\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class FichePreInscription extends AbstractType
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

            ->add('submit', SubmitType::class, ['label' => "Ajouter", 'attr' => ['class' => 'btn-primary']]);
    }
}
