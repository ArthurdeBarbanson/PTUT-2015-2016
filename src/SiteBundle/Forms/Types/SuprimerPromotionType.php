<?php

namespace SiteBundle\Forms\Types;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class SuprimerPromotionType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('promo', EntityType::class, [
                'label' => 'Promotion',
                'choices' => $options['data'],
                'class' => 'SiteBundle\Entity\Session',
                'choice_label' => 'anneeScolaire',
            ])
            ->add('submit', SubmitType::class, ['label' => "Supprimer", 'attr' => ['class' => 'btn-danger']]);
    }

}
