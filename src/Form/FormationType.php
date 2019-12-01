<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Formation;
use App\Repository\CoursRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('code')
            /*->add('Courses', EntityType::class, [
                'class' => Cours::class,
                'choice_label' => 'title',
                'query_builder' => function(CoursRepository $cr) {
                    return $cr->createQueryBuilder('u')
                        ->orderBy('u.title', 'ASC');
                },
                'multiple' => true,
                'expanded' => true])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
