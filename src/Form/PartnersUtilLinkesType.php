<?php

namespace App\Form;

use App\Entity\PartnersUtilLinkes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnersUtilLinkesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'row_attr'=>['class'=>'mb-3'], 
                'label'=>"Titre de l'url",
                'required'=>true,

                'attr' => ['class' => 'form-control'],
            ])
            ->add('value', UrlType::class, [
                'row_attr'=>['class'=>'mb-3'], 
                'label'=>'URL',
                'required'=>true,

                'attr' => ['class' => 'form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PartnersUtilLinkes::class,
        ]);
    }
}
