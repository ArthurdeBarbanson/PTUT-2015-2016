<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 10/05/16
 * Time: 10:07
 */

namespace SiteBundle\Forms\Types;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RefuserAnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Message', TextareaType::class,[
                'constraints'=>[
                    new NotBlank(),
                    new Length(['min'=>3])

                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => ['class' => 'btn btn-default  center-block'],
            ]);
    }
}