<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Matiere;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom' ,TextType::class,[
                "label" => 'nom ' ,
            ])
            ->add('prix')

            ->add('matiere', EntityType::class, [
                'class'=> Matiere::class,
                'choice_label'=> 'nomM',

            ])


            ->add('imgSrc',FileType::class,[
                'label'=> false,
                'multiple'=> false,
                'required' => false,
                'data_class' => null,
                'mapped'=> false,

            ])

            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
