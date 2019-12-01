<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Discipline;
use App\Entity\Formation;
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
            ->add('hours')
            ->add('formations', EntityType::class, [
                'class' => Formation::class,
                'choice_label' => 'code',
                'multiple' => true
            ])
            ->add('teachers', EntityType::class, [
                'class' => Teacher::class,
                'choice_label' => 'lastname',
                'multiple' => true
            ])
            ->add('discipline', EntityType::class, [
                'class' => Discipline::class,
                'choice_label' => 'title'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
