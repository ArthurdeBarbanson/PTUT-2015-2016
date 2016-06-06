<?php

namespace SiteBundle\Forms\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjoutPromotionType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDebut', DateType::class, [
                'label' => 'Date de début'
            ])
            ->add('dateFin', DateType::class, [
                'label' => 'Date de fin'
            ])
            ->add('anneeScolaire', TextType::class, [
                'label' => 'Libelle',
                'attr' => ['placeholder' => '2000/2001']
            ])
            ->add('submit', SubmitType::class, ['label' => "Ajouter", 'attr' => ['class' => 'btn-primary']]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SiteBundle\Entity\Session'
        ));
    }


}
