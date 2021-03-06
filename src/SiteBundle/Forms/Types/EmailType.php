<?php

namespace SiteBundle\Forms\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EmailType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('transport', ChoiceType::class,[
                'choices'=>[
                    'smtp'=>'smtp',
                    'mail'=>'mail',
                    'sendmail'=>'sendmail',
                    'gmail'=>'gmail',
                ]
            ])
            ->add('host', TextType::class,[
                'constraints'=>[
                    new NotBlank(),
                    new Length(['min'=>3])

                ]
            ])
            ->add('username', TextType::class,[
                'constraints'=>[
                    new NotBlank(),
                    new Length(['min'=>3])

                ]
            ])
            ->add('password', TextType::class,[
                'constraints'=>[
                    new NotBlank(),
                    new Length(['min'=>3])

                ]
            ])

            ->add('port', NumberType::class)
            ->add('encryption', ChoiceType::class,[
                'choices'=>[
                    'tls'=>'tls',
                    'ssl'=>'ssl'
                ]
            ])



            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => ['class' => 'btn btn-default  center-block'],
            ]);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SiteBundle\Entity\Email'
        ));
    }
}
