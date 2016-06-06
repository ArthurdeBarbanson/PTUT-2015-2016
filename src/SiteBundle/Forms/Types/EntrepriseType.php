<?php

namespace SiteBundle\Forms\Types;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
            ->add('telephone', NumberType::class, [
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
            ->add('nom')
            ->add('submit', SubmitType::class, ['label' => "S'inscrire", 'attr' => ['class' => 'btn-primary']]);
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SiteBundle\Entity\Entreprise'
        ));
    }
}
