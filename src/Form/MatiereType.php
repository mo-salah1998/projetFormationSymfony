<?php

namespace App\Form;

use App\Entity\Matiere;
use phpDocumentor\Reflection\Types\False_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatiereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomM')
            ->add('prixM')
            ->add('imgSrc',FileType::class,[
                'label'=> true,
                'multiple'=> false,
                'required' => false,
                'data_class' => null


            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Matiere::class,
        ]);
    }
}
