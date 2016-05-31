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
                'label'    => 'Oui',
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
            ->add('AnneeDernierDiplome', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Annee'
                ]
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
            ->add('AnneeAutreEtablissement', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Annee'
                ]
            ])
            ->add('CodeAutreEtablissement', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Code'
                ]
            ])
            ->add('isInscrit', CheckboxType::class, [
                'label'    => 'Oui',
                'required' => true
            ])
            ->add('isInscriptionMainteanue', CheckboxType::class, [
                'label'    => 'Oui',
                'required' => true
            ])
            ->add('AnneePremiereInscription', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Annee'
                ]
            ])
            ->add('AnneeUniversitePremiereInscription', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Annee'
                ]
            ])
            ->add('NomPremiereInscription', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Annee'
                ]
            ])
            ->add('AnneeSUPPremiereInscription', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'attr' => [
                    'placeholder' => 'Annee'
                ]
            ])


            ->add('submit', SubmitType::class, ['label' => "Ajouter", 'attr' => ['class' => 'btn-primary']]);
    }
}
