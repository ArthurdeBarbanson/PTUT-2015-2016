<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 31/03/2016
 * Time: 11:24
 */

namespace SiteBundle\Forms\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class CreateMap extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Civilite', ChoiceType::class, array(
                'choices' => array('H' => 'Monsieur', 'F' => 'Madame'),
                'label' => 'Civilité',
                'multiple' => false,
                'expanded'=>true,
            ))
            ->add('Nom', TextType::class, array(
                'label' => 'Nom du maitre d\'apprentissage',

            ))
            ->add('Prenom', TextType::class, array(
                'label' => 'Prenom du maitre d\'apprentissage',

            ))
            ->add('DateN', BirthdayType::class, array(
                'label' => 'Date de Naissance',

                          ))
            ->add('Fonction', TextType::class, array(
                'label' => 'Fonction',

            ))
            ->add('Tel', TextType::class, array(
                'label' => 'Telephone du maitre d\'apprentissage',

            ))
            ->add('Email', TextType::class, array(
                'label' => 'Email du maitre d\'apprentissage',

            ))
            ->add('DejaMaj',  ChoiceType::class, array(
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
            ->add('submit', SubmitType::class, [
                'label' => 'Poster',
                'attr' => ['class' => 'btn-primary btn-lg center-block', 'style' => "margin-top:20px"],
            ]);

   }
}