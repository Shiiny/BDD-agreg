<?php

namespace App\Form;

use App\Entity\Concours;
use App\Entity\Cours;
use App\Entity\Teacher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConcoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('code_t')
            ->add('public')
            ->add('code_p')
            ->add('material')
            ->add('code_m')
            ->add('categorie')
            ->add('code_c')
            ->add('title')
            ->add('code_cohorte')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Concours::class,
        ]);
    }
}
