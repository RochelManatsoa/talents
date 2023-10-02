<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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
            ->add('description', TextareaType::class, [
                'label' => 'app_identity_company.desc',
                'required' => true,
                'attr' => [
                    'rows' => 8
                ]
            ])
            ->add('website', TextType::class, ['label' => 'app_identity_company.website',])
            ->add('country', CountryType::class, [
                'label' => 'app_identity_company.country',
                'required' => false,
                'placeholder' => 'app_identity_company.select',
            ])
            ->add('email', EmailType::class, ['label' => 'app_identity_company.email',])
            ->add('phone', TextType::class, ['label' => 'app_identity_company.phone',])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
