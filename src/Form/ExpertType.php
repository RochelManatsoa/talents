<?php

namespace App\Form;

use App\Entity\Expert;
use App\Entity\Sector;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ExpertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('country', CountryType::class, [
                'label' => 'app_identity_expert.localisation',
                'required' => false,
                'label_attr' => ['class' => 'col-form-label'],
                'placeholder' => 'app_identity_expert.select',
            ])
            ->add('title', TextType::class, [
                'required' => false,
                'label' => 'app_identity_expert.name',
                'label_attr' => ['class' => 'col-sm-4 text-center col-form-label'],
                ])
            ->add('years', ChoiceType::class, [
                'choices' => Expert::CHOICE_YEAR,
                'label' => 'app_identity_expert.year',
                'required' => true,
            ])
            ->add('sectors', EntityType::class, [
                'class' => Sector::class,
                'label' => 'app_identity_company.sector_multiple',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
            ])
            ->add('aspiration', TextareaType::class, [
                'label' => 'app_identity_expert.aspiration',
                'label_attr' => ['class' => 'col-sm-4 text-center col-form-label'],
                'required' => false,
                'attr' => [
                    'rows' => 8
                ]
            ])
            ->add('cv', FileType::class, [
                'label' => 'app_identity_expert.cv',
                'label_attr' => ['class' => 'col-sm-4 text-center col-form-label'],
                'mapped' => false,
                'required' => false,
                'attr' => ['class' => 'custom-file-input'],
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])            
            ->add('website', TextType::class, [
                'label' => 'app_identity_expert.website',
                'required' => false,
            ])
            ->add('birthday', DateType::class, [
                'label' => 'Votre anniversaire',
                'label_attr' => ['class' => 'col-sm-4 text-center col-form-label'],
                'years' => range(1970, 2010),
                'attr' => ['class' => 'rounded-pill'] 
            ])
            ->add('phone', TextType::class, [
                'label' => 'app_identity_company.phone',
                'required' => true,
            ])
            ->add('email', EmailType::class, [
                'label' => 'app_identity_company.email',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Expert::class,
        ]);
    }
}
