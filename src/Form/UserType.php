<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label_attr' => ['class' => 'col-sm-4 text-center col-form-label'],
                'label' => 'app_identity_expert_step_one.user.firstName',
            ])
            ->add('lastName', TextType::class, [
                'label_attr' => ['class' => 'col-sm-4 text-center col-form-label'],
                'label' => 'app_identity_expert_step_one.user.lastName',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
