<?php

namespace App\Form\Step;

use App\Form\UserType;
use App\Entity\Identity;
use App\Form\ExpertType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StepOneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', UserType::class, ['label' => false])
            ->add('file', VichImageType::class, [
                'required' => false,
                'label' => 'app_identity_expert_step_one.avatar',
                'download_label' => false,
                'attr' => ['class' => 'rounded-pill'],
                'allow_delete' => false
            ])
            ->add('expert', ExpertType::class, ['label' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Identity::class,
        ]);
    }
}
