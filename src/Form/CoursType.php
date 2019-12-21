<?php

namespace App\Form;

use App\Entity\Concours;
use App\Entity\Cours;
use App\Entity\Discipline;
use App\Entity\Teacher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('id_moodle')
            ->add('concours', EntityType::class, [
                'class' => Concours::class,
                'choice_label' => 'code_cohorte',
                'multiple' => true,
            ])
            ->add('teachers', EntityType::class, [
                'class' => Teacher::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
            ->add('discipline', EntityType::class, [
                'class' => Discipline::class,
                'choice_label' => 'title',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
