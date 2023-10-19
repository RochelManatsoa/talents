<?php

namespace App\Form;

use App\Entity\Posting;
use App\Entity\Sector;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PostingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => false,])
            ->add('type', null, ['label' => 'app_dashboard_company_posting_new.type'])
            ->add('sector', EntityType::class, [
                'label' => 'app_dashboard_company_posting_new.sector',
                'class' => Sector::class,
                'attr' => []
            ])
            ->add('description', TextareaType::class, [
                'label' => 'app_dashboard_company_posting_new.desc_form',
                'required' => true,
                'attr' => [
                    'rows' => 8
                ]
            ])
            ->add('tarif', MoneyType::class, ['label' => 'app_dashboard_company_posting_new.tarif'])
            ->add('number', NumberType::class, ['label' => 'app_dashboard_company_posting_new.number',])
            ->add('plannedDate', DateType::class, [
                'label' => 'app_dashboard_company_posting_new.planned_date',
                'widget' => 'single_text',  
                'format' => 'yyyy-MM-dd',   
                'data' => new \DateTime('now'),
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Posting::class,
        ]);
    }
}
