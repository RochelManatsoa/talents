<?php

namespace App\Form;

use App\Entity\Sector;
use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'app_identity_company.name',])
            ->add('size', ChoiceType::class, [
                'choices' => Company::CHOICE_SIZE,
                'label' => 'app_identity_company.size',
                'required' => true,
                ])
            ->add('sectors', EntityType::class, [
                'class' => Sector::class,
                'label' => 'app_identity_company.sector_multiple',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                ])
            ->add('description', TextareaType::class, [
                'label' => 'app_identity_company.desc',
                'required' => false,
                'attr' => [
                    'rows' => 8,
                    'placeholder' => "200 à 300 caractères"
                ]
            ])
            ->add('website', TextType::class, [
                'label' => 'app_identity_company.website',
                'required' => false,
            ])
            ->add('country', CountryType::class, [
                'label' => 'app_identity_company.country',
                'required' => true,
                'placeholder' => 'app_identity_company.select',
            ])
            ->add('email', EmailType::class, [
                'label' => 'app_identity_company.email',
                'required' => true,
            ])
            ->add('phone', TextType::class, [
                'label' => 'app_identity_company.phone',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
