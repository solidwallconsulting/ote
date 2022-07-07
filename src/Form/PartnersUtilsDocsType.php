<?php

namespace App\Form;

use App\Entity\PartnersUtilsDocs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnersUtilsDocsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        

            ->add('name', TextType::class, [
                'row_attr'=>['class'=>'mb-3'],

                'label'=>'Titre de document',
                'required'=>true,

                'attr' => ['class' => 'form-control'],
            ])

            ->add('docURL', FileType::class, [
                'row_attr'=>['class'=>'mb-3'],
                'mapped'=>false,
                'label'=>'Document PDF',
                'required'=>false,

                'attr' => ['class' => 'form-control'],
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PartnersUtilsDocs::class,
        ]);
    }
}
