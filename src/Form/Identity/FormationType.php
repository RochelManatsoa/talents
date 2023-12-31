<?php

namespace App\Form\Identity;

use App\Entity\Identity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'app_identity_expert_step_two.formation.title',
            ])
            ->add('level', TextType::class, [
                'label' => 'app_identity_expert_step_two.formation.level',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'app_identity_expert_step_two.formation.description',
                'required' => false,
                'attr' => [
                    'rows' => 6
                ]
            ])
            ->add('currently', CheckboxType::class, [
                'label' => 'app_identity_expert_step_two.formation.currently',
                'required' => false,
            ])
            ->add('startDate', DateType::class,  [
                'label' => 'app_identity_expert_step_two.experience.startDate',
                'years' => range(1950, (new \DateTime('now'))->format("Y")),
                'attr' => ['class' => 'rounded-pill'] 
            ])
            ->add('endDate', DateType::class,  [
                'label' => 'app_identity_expert_step_two.experience.endDate',
                'years' => range(1950, 2100),
                'attr' => ['class' => 'rounded-pill'] ,
                'data' => new \DateTime('now'),
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'app_identity_expert_step_two.skill.submit',
                'attr' => [
                    'class' => 'btn btn-dark rounded-pill'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
