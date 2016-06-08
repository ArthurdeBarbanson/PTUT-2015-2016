<?php

namespace SiteBundle\Forms\Types;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EntrepriseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('raisonSocial', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3])
                ],
                'label' => 'Nom du contact'
            ])
            ->add('prenom', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3])
                ],
                'label' => 'Prenom du contact'
            ])
            ->add('mail', EmailType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Email([
                        'strict'=> false,
                        'checkMX'=>true,
                        'checkHost'=>true
                    ])
                ],
                'label' => 'E-mail du contact'
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Telephone du contact',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 10, 'max' => 12])]
            ])
            ->add('Adresse', AdresseType::class,
                array('label' => 'Localisation'))
            ->add('siteWeb', UrlType::class, array(
                'required' => false,
            ))
            ->add('nombrePersonne', IntegerType::class)
            ->add('siret', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('aPE', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('CiviliteD', ChoiceType::class, array(
                'choices' => array(' Monsieur ' => 'M', 'Madame ' => 'F'),
                'label' => 'Civilité',
                'multiple' => false,
                'expanded' => true,
                'required' => true,
            ))
            ->add('FunctionD', ChoiceType::class, array(
                'choices' => array(' Dirigeant ' => 'Dirigeant', 'DRH ' => 'DRH'),
                'label' => 'Fonction',
                'multiple' => false,
                'expanded' => true,
                'required' => true,
            ))
            ->add('PrenomD', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3])
                ],
                'label' => 'Prenom du dirigeant',
            ])
            ->add('NomD', TextType::class, ['constraints' => [
                new NotBlank(),
                new Length(['min' => 3])
            ],
                'label' => 'Nom du dirigeant',
            ])
            ->add('MailD', EmailType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Email([
                        'strict' => false,
                        'checkMX' => true,
                        'checkHost' => true
                    ])
                ],
                'label' => 'E-mail du dirigeant',
            ])

            ->add('submit', SubmitType::class, ['label' => "S'inscrire", 'attr' => ['class' => 'btn-primary']]);
        ;
    }

}
