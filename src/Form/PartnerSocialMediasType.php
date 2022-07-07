<?php

namespace App\Form;

use App\Entity\PartnerSocialMedias;
use App\Entity\SocialMedias;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnerSocialMediasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('socialMedia', EntityType::class, [
                // looks for choices from this entity
                'label'=>'Réseaux social',
                'class' => SocialMedias::class,  
                'row_attr'=>['class'=>'mb-3'],
                'attr' => ['class' => 'form-control'],
                'required'=>true,
                "placeholder"=>'Veuiller choisir une valeur'
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
            'data_class' => PartnerSocialMedias::class,
        ]);
    }
}
