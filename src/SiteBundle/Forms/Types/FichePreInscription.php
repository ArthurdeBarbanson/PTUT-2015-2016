<?php

namespace SiteBundle\Forms\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class FichePreInscription extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Intitule', TextType::class, [
                'constraints' => [ new NotBlank() ],
                'attr' => [
                        'placeholder' => 'Intitule'
                        ]
            ])
            ->add('Mention', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Mention'
                ]
            ])
            ->add('Type', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Etablissement'
                ]
            ])
            ->add('Departement', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Etablissement'
                ]
            ])
            ->add('Nom', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Etablissement'
                ]
            ])
            ->add('NomDernier', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Nom'
                ]
            ])
            ->add('DepartementDernier', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Departement'
                ]
            ])
            ->add('AnneDernier', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Annee'
                ]
            ])
            ->add('TypeDernier', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Type'
                ]
            ])
            ->add('isLyon', CheckboxType::class, [
                'label'    => 'Oui',
                'required' => true
            ])
            ->add('isTransfert', CheckboxType::class, [
                'label'    => 'isTransfert',
                'required' => true
            ])


            ->add('submit', SubmitType::class, ['label' => "Ajouter", 'attr' => ['class' => 'btn-primary']]);
    }
}
