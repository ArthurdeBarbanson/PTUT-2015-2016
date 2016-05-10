<?php

namespace SiteBundle\Forms\Types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class AjoutEtudiantImport extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('csv', FileType::class, [
                'label' => 'Importer les étudiants',
            ])
            ->add('submit', SubmitType::class, ['label' => "Ajouter les étudiants", 'attr' => ['class' => 'btn-primary']]);
    }
}
