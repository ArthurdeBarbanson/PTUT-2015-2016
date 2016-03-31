<?php

namespace SiteBundle\Forms\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PostulerAnnonce extends AbstractType

{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array(
                'label' => 'Nom',
                'required' => true,
            ))
            ->add('prenom', TextType::class, array(
                'label' => 'Prenom',
                'required' => true,
            ))
            ->add('importCV', ChoiceType::class, array(
                'choices' => array('cvImport' => 'Importer mon CV', 'utiliserCV' => 'Utiliser le CV existant'),
                'multiple' => false, 'expanded' => true,
            ))
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => ['class' => 'btn-primary btn-lg center-block'],
            ]);
    }
}