<?php

namespace App\Form;

use App\Entity\Expert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ExpertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'app_identity_expert.name',])
            ->add('years', ChoiceType::class, [
                'choices' => Expert::CHOICE_YEAR,
                'label' => 'app_identity_expert.year',
                'required' => true,
                ])
            ->add('country', CountryType::class, [
                'label' => 'app_identity_expert.localisation',
                'required' => false,
                'placeholder' => 'app_identity_expert.select',
            ])
            ->add('mainSkills', TextareaType::class, [
                'label' => 'app_identity_expert.main_skills',
                'required' => true,
                'attr' => [
                    'rows' => 8
                ]
            ])
            ->add('aspiration', TextareaType::class, [
                'label' => 'app_identity_expert.aspiration',
                'required' => true,
                'attr' => [
                    'rows' => 8
                ]
            ])
            ->add('preference', TextareaType::class, [
                'label' => 'app_identity_expert.preference',
                'required' => true,
                'attr' => [
                    'rows' => 8
                ]
            ])
            ->add('website', TextType::class, [
                'label' => 'app_identity_expert.website',
                'required' => false,
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
