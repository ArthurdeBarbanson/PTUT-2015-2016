<?php

namespace SiteBundle\Forms\Types;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DossierAdmissionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('commentaire', TextareaType::class, [
                'required' => false
            ])
            ->add('dateLimite', DateTimeType::class, [
                'label' => 'Date limite du dossier',
            ])
            ->add('submit', SubmitType::class, ['label' => "Mettre à jour"])
            ->add('accepter', SubmitType::class, ['label' => "Accepter l'étudiant"])
            ->add('refuser', SubmitType::class, ['label' => "Refuser l'étudiant"]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SiteBundle\Entity\DossierAdmission'
        ));
    }
}
