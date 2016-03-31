<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 31/03/2016
 * Time: 11:24
 */

namespace SiteBundle\Forms\Types;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateMap
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Civilite', ChoiceType::class, array(
                'choices' => array('H' => 'Homme', 'F' => 'Femme'),
                'label' => 'Civilité',
                'data' => 'Oui'
            ))
            ->add('Nom', TextType::class, array(
                'label' => 'Nom du maitre d\'apprentissage',
                'attr' => ['class' => 'form-control'],

            ))
            ->add('Prenom', TextType::class, array(
                'label' => 'Prenom du maitre d\'apprentissage',
                'attr' => ['class' => 'form-control'],

            ))
            ->add('DateN', TextType::class, array(
                'label' => 'Date de Naissance',
                'attr' => ['class' => 'form-control'],

            ))
            ->add('Fonction', TextType::class, array(
                'label' => 'Date de Naissance',
                'attr' => ['class' => 'form-control'],

            ))
            ->add('Tel', TextType::class, array(
                'label' => 'Telephone du maitre d\'apprentissage',
                'attr' => ['class' => 'form-control'],

            ))
            ->add('Mobil', TextType::class, array(
                'label' => 'Mobile du maitre d\'apprentissage',
                'attr' => ['class' => 'form-control'],

            ))
            ->add('Email', TextType::class, array(
                'label' => 'Email du maitre d\'apprentissage',
                'attr' => ['class' => 'form-control'],
            ))
            ->add('DejaMaj',  HChoiceType::class, array(
                'choices' => array('Oui' => 'true', 'Non' => 'False'),
                'label' => 'A t\'il déja été  maitre d\'apprentissage ',
                'multiple' => false,
                'expanded'=>true,
            ))
            ->add('DejaFormerMaj', ChoiceType::class, array(
                'choices' => array('Oui' => 'true', 'Non' => 'False'),
                'label' => 'A t\'il déja suivis une formation de  maitre d\'apprentissage ',
                'multiple' => false,
                'expanded'=>true,
            ))
        ;



    }
}