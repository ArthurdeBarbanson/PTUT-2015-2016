<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 11/05/2016
 * Time: 10:43
 */

namespace SiteBundle\Forms\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;


class AssignerTuteur extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
            ->add('submit', SubmitType::class, [
                'label' => 'Poster',
                'attr' => ['class' => 'btn-primary btn-lg center-block', 'style' => "margin-top:20px"],
            ]);

    }
}