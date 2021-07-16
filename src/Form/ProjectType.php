<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('beginning', DateType::class, array(
                'label' => "Modifier la date de commencement",
                'widget' => 'single_text'))
            ->add('end', DateType::class, array(
                'label' => "Modifier la date d'achèvement",
                'widget' => 'single_text'))
            ->add('title', null, [
                'label' => "Type"])
            ->add('content', null, [
                  'label' => "Déscription"])

                  //Ajouter dropdown pour achiver
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
