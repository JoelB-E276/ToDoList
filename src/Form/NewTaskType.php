<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\Project;
use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NewTaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

        ->add('title', null, [
            'label' => "Nom de la tâche"])
        ->add('beginning', DateType::class, array(
            'label' => "Date de commencement",
            'widget' => 'single_text'))
        ->add('end', DateType::class, array(
            'label' => "Date d'achèvement",
            'widget' => 'single_text'))
        ->add('content', null, [
              'label' => "Description"])
        ->add('status', ChoiceType::class, [
                'choices'  => [
                    'En cours' => 'En cours',
                    'Terminé' => 'Terminé',
                ],
            ])
     

        ->add('Ajouter', SubmitType::class, [
                'row_attr' => ['class' => 'text-center']
            ],)  
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
