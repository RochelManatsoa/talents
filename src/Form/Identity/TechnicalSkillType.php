<?php

namespace App\Form\Identity;

use App\Entity\Identity\TechnicalSkill;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TechnicalSkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'app_identity_expert_step_two.skill.name',
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'app_identity_expert_step_two.skill.level',
                'choices'  => [
                    'app_identity_expert_step_two.skill.one' => 1,
                    'app_identity_expert_step_two.skill.two' => 2,
                    'app_identity_expert_step_two.skill.three' => 3,
                    'app_identity_expert_step_two.skill.four' => 4,
                    'app_identity_expert_step_two.skill.five' => 5,
                ],
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
            'data_class' => TechnicalSkill::class,
        ]);
    }
}
