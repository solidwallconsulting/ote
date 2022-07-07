<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Partners;
use App\Entity\Region;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class PartnersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'row_attr'=>['class'=>'mb-3'],

                'label'=>'Nom',
                'required'=>true,

                'attr' => ['class' => 'form-control'],
            ])
            ->add('about', CKEditorType::class, [
                'row_attr'=>['class'=>'mb-3'],

                'label'=>'A propos',
                'required'=>true,

                'attr' => ['class' => 'form-control'],
            ])
            /*
            ->add('category' , EntityType::class, [
                // looks for choices from this entity
                'class' => Category::class, 
                'choice_label' => 'name',
                'row_attr'=>['class'=>'mb-3'],
                'attr' => ['class' => 'form-control'],
                'required'=>true,
                "placeholder"=>'Veuiller choisir une category'
            ])
             */
            /*->add('region' , EntityType::class, [
                // looks for choices from this entity
                'class' => Region::class, 
                'choice_label' => 'name',
                'row_attr'=>['class'=>'mb-3'],
                'attr' => ['class' => 'form-control'],
                'required'=>true,
                "placeholder"=>'Veuiller choisir une region'
            ])*/
            ->add('address', TextType::class, [
                'row_attr'=>['class'=>'mb-3'],

                'label'=>'Adresse',
                'required'=>true,

                'attr' => ['class' => 'form-control'],
            ])


            ->add('logoURL', FileType::class, [
                'row_attr'=>['class'=>'mb-3'],
                'mapped'=>false,
                'label'=>'Logo',
                'required'=>true,

                'attr' => ['class' => 'form-control'],
            ])
            
            ->add('phone', TextType::class, [
                'row_attr'=>['class'=>'mb-3'],

                'label'=>'Télephone',
                'required'=>true,

                'attr' => ['class' => 'form-control'],
            ])
            ->add('phone2', TextType::class, [
                'row_attr'=>['class'=>'mb-3'],

                'label'=>'Fax',
                'required'=>true,

                'attr' => ['class' => 'form-control'],
            ])
            ->add('email', EmailType::class, [
                'row_attr'=>['class'=>'mb-3'],

                'label'=>'E-mail',
                'required'=>true,

                'attr' => ['class' => 'form-control'],
            ])
            ->add('website', UrlType::class, [
                'row_attr'=>['class'=>'mb-3'],

                'label'=>'URL',
                'required'=>true,

                'attr' => ['class' => 'form-control'],
            ])
            ->add('youtubeFrame', TextType::class, [
                'row_attr'=>['class'=>'mb-3'],

                'label'=>'Vidéo YouTube',
                'required'=>false,

                'attr' => ['class' => 'form-control'],
            ])

            ->add('coverImageURL', FileType::class, [
                'row_attr'=>['class'=>'mb-3'],
                'mapped'=>false,
                'label'=>'Image de couverture', 

                'attr' => ['class' => 'form-control'],
                'required'=>false,
            ])
            

 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partners::class,
        ]);
    }
}
