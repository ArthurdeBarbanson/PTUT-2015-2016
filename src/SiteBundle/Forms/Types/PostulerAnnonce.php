<?php

namespace SiteBundle\Forms\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('isImportCV', ChoiceType::class, array(
                'choices' => array('Importer mon CV' => 'cvImport', 'Utiliser le CV existant' => 'utiliserCV'),
                'multiple' => false, 'expanded' => true,
            ))
            ->add('cvImport', FileType::class, array(
                'label' => 'Importer mon CV',
            ))
            ->add('lettreMotivation', TextareaType::class, array(
                'label' => 'Ecrir ma lettre de motivation'
            ))
            ->add('lettreMotivationImport', FileType::class, array(
                'label' => 'Importer ma lettre de motivation',
            ))
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => ['class' => 'btn btn-default  center-block'],
            ]);
    }
}