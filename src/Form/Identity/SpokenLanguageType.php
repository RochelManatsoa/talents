<?php

namespace App\Form\Identity;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Entity\Identity\SpokenLanguage;
use App\Entity\Language;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SpokenLanguageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('language', EntityType::class, [
                'class' => Language::class,
                'label' => 'app_identity_expert_step_two.language.label',
            ])
            ->add('level', ChoiceType::class, [
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
                'label' => 'app_identity_expert_step_two.experience.submit',
                'attr' => [
                    'class' => 'btn btn-dark rounded-pill'
                ]
            ])
        ;
        
        $builder->addEventListener(
            FormEvents::SUBMIT,
            function (FormEvent $event): void {

                $data = $event->getData();
                $lang = $data->getLanguage()->getName();
                $code = $data->getLanguage()->getCode();
                
                $data->setTitle($lang);
                $data->setCode($code);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SpokenLanguage::class,
        ]);
    }
}
