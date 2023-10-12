<?php

namespace App\Form;

use App\Entity\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('motivation', TextareaType::class, [
                'label' => 'app_catalog_posting.motivation',
                'required' => true,
                'attr' => [
                    'rows' => 8,
                    'placeholder' => "Bonjour,\nje suis intéressé(e) par votre offre.\nJe vous remercie d'avance de considérer ma candidature pour le poste de…"
                ]
            ])
            ->add('apply', SubmitType::class, [
                'label' => 'Postuler',
                'attr' => [
                    'class' => 'btn rounded-pill btn-dark',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
