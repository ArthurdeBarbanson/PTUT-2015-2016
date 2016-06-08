<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 08/06/16
 * Time: 11:58
 */

namespace SiteBundle\Forms\Types;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class AjoutPieceJointe  extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Etape', ChoiceType::class,[
                'choices'=>[
                    'Etape 1'=>'1',
                    'Etape 2'=>'2',
                    'Etape 3'=>'3',
                    'Etape 4'=>'4',
                    'Etape 5'=>'5',
                    'Etape 6'=>'6',
                ]
            ])

            ->add('pieceJointe', FileType::class, [
                'label' => 'Pièce jointe',
//                'attr' => ['accept' => 'application/pdf']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter une pièce jointe',
                'attr' => ['class' => 'btn btn-default  center-block'],
            ]);
    }
}