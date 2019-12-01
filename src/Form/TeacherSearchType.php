<?php


namespace App\Form;


use App\Entity\BddSearch;
use App\Entity\Teacher;
use App\Repository\TeacherRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeacherSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('teacher', EntityType::class, [
                'placeholder' => 'Selectionnez un enseignant',
                'class' => Teacher::class,
                'choice_label' => function ($teacher) {
                    return $teacher->getName();
                },
                'query_builder' => function (TeacherRepository $tr) {
                    return $tr->createQueryBuilder('t')
                        ->orderBy('t.lastname', 'ASC');
                },
                'choice_value' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}

{

}