<?php

namespace App\Form\Step;

use App\Entity\Identity;
use App\Form\Expert\CvType;
use App\Form\ExpertType;
use App\Form\Identity\ExperienceType;
use App\Form\Identity\FormationType;
use App\Form\Identity\SpokenLanguageType;
use Symfony\Component\Form\AbstractType;
use App\Form\Identity\TechnicalSkillType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class StepTwoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('expert', ExpertType::class, ['label' => false])
            ->add('technicalSkills', CollectionType::class, [
                'entry_type' => TechnicalSkillType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('formations', CollectionType::class, [
                'entry_type' => FormationType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('experiences', CollectionType::class, [
                'entry_type' => ExperienceType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('languages', CollectionType::class, [
                'entry_type' => SpokenLanguageType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Identity::class,
        ]);
    }
}
