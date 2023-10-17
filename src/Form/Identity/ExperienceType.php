<?php

namespace App\Form\Identity;

use App\Entity\Identity\Experience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'app_identity_expert_step_two.experience.title',
            ])
            ->add('company', TextType::class, [
                'label' => 'app_identity_expert_step_two.experience.company',
            ])
            ->add('currently', CheckboxType::class, [
                'label' => 'app_identity_expert_step_two.experience.currently',
                'required' => false,
            ])
            ->add('startDate', DateType::class,  [
                'label' => 'app_identity_expert_step_two.experience.startDate',
                'widget' => 'single_text',  
                'format' => 'yyyy-MM-dd',   
            ])
            ->add('endDate', DateType::class,  [
                'label' => 'app_identity_expert_step_two.experience.endDate',
                'widget' => 'single_text',  
                'format' => 'yyyy-MM-dd',   
            ])
            ->add('description', TextareaType::class, [
                'label' => 'app_identity_expert_step_two.experience.description',
                'required' => false,
                'attr' => [
                    'rows' => 6
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'app_identity_expert_step_two.experience.submit',
                'attr' => [
                    'class' => 'btn btn-dark rounded-pill'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Experience::class,
        ]);
    }
}
