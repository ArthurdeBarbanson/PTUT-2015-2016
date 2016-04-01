<?php

namespace SiteBundle\Forms\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RechercheOffresType extends AbstractType

{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('motsCles', TextType::class, array(
                'label' => 'Mots clés',
                'required' => false,
            ))
            ->add('villeDep', TextType::class, array(
                'label' => 'Ville/dpt',
                'required' => false,
            ))
            ->add('licence', ChoiceType::class, array(
                'choices' => array('IEM' => 'iem', 'Metinet' => 'metienet'),
                'multiple' => true, 'expanded' => true
            ))
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => ['class' => 'btn btn-default'],
            ]);
    }
}