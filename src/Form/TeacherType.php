<?php

namespace App\Form;

use App\Entity\Concours;
use App\Entity\Discipline;
use App\Entity\Teacher;
use App\Repository\ConcoursRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeacherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('idMoodle')
            ->add('email')
            ->add('phone')
            ->add('discipline', EntityType::class, [
                'required' => false,
                'class' => Discipline::class,
                'choice_label' => 'title'
            ])
            ->add('concours', EntityType::class, [
                'required' => false,
                'class' => Concours::class,
                'choice_label' => 'code_cohorte',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Teacher::class,
            'translation_domain' => 'forms'
        ]);
    }
}
