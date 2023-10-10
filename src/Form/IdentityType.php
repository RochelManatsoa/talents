<?php

namespace App\Form;

use App\Entity\Identity;
use App\Entity\User;
use App\Form\Identity\SocialType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IdentityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', UserType::class, [ 'label' => false ])
            ->add('bio')
            // ->add('username')
            ->add('phone')
            // ->add('fileName')
            // ->add('account')
            // ->add('company')
            ->add('expert', ExpertType::class, ['label' => false])
            ->add('technicalSkills')
            ->add('formations')
            ->add('social', SocialType::class, [])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Identity::class,
        ]);
    }
}
