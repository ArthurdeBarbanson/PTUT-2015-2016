<?php

namespace SiteBundle\Forms\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
            ->add('AnneDernier', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('TypeDernier', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Type'
                ]
            ])
            ->add('isLyon', ChoiceType::class, [
                'choices' => array(' Oui ' => '1', 'Nom ' => '0'),
                'label' => 'isLyon',
                'multiple' => false,
                'expanded' => true,
                'required' => true
            ])
            ->add('isTransfert', ChoiceType::class, [
                'choices' => array(' Oui ' => '1', 'Nom ' => '0'),
                'label' => 'isTransfert',
                'multiple' => false,
                'expanded' => true,
                'required' => true
            ])
            ->add('DerpartementDernierDiplome', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Departement'
                ]
            ])
            ->add('AnneeDernierDiplome', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('EtablissementDernierDiplome', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Etablissement'
                ]
            ])
            ->add('IntituleDernierDiplome', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Intitule'
                ]
            ])
            ->add('NomAutreEtablissement', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Nom'
                ]
            ])
            ->add('TypeAutreEtablissement', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Type'
                ]
            ])
            ->add('DepartementAutreEtablissement', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Departement'
                ]
            ])
            ->add('AnneeAutreEtablissement', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('CodeAutreEtablissement', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Code'
                ]
            ])
            ->add('isInscrit', ChoiceType::class, [
                'choices' => array(' Oui ' => '1', 'Nom ' => '0'),
                'label' => 'isInscrit',
                'multiple' => false,
                'expanded' => true,
                'required' => true
            ])
            ->add('isInscriptionMainteanue', ChoiceType::class, [
                'choices' => array(' Oui ' => '1', 'Nom ' => '0'),
                'label' => 'isInscriptionMaintenue',
                'multiple' => false,
                'expanded' => true,
                'required' => true
            ])
            ->add('AnneePremiereInscription', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('AnneeUniversitePremiereInscription',DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('NomPremiereInscription', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Nom'
                ]
            ])
            ->add('AnneeSUPPremiereInscription', DateType::class, [
                'widget' => 'single_text'
            ])


            ->add('submit', SubmitType::class, ['label' => "Ajouter", 'attr' => ['class' => 'btn-primary']]);
    }
}
