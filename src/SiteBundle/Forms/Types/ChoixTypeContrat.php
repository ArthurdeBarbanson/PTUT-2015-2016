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


class ChoixTypeContrat extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeContrat', ChoiceType::class, [
                'choices' => array(' Contrat Apprentissage ' => 'Apprentissage', 'Contrat Professionnalisation ' => 'Professionnalisation'),
                'label' => 'Type Contrat',
                'multiple' => false,
                'expanded' => true,
                'required' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => ['class' => 'btn-primary btn-lg center-block', 'style' => "margin-top:20px"],
            ]);

    }
}