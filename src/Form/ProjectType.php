<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'label' => "Nom du projet"])
            ->add('beginning', DateType::class, array(
                'label' => "Modifier la date de commencement",
                'widget' => 'single_text'))
            ->add('end', DateType::class, array(
                'label' => "Modifier la date d'achèvement",
                'widget' => 'single_text'))
            ->add('content', null, [
                  'label' => "Description"])

                  // Changer label status -> statut
            ->add('status', ChoiceType::class, [
                    'choices'  => [
                        'En cours' => 'En cours',
                        'Terminé' => 'Terminé',
                    ],
                ])   
                    // Changer label archived -> archiver

            ->add('archived', ChoiceType::class, [
                    'choices'  => [
                        'Non' => 'non',
                        'Oui' => 'oui',
                    ],
                ])         

                 
            ->add('Modifier', SubmitType::class, [
                    'row_attr' => ['class' => 'text-center']
                ],)  
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
