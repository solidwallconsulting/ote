<?php

namespace App\Form;

use App\Entity\Countries;
use App\Entity\Region;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $editPhoto = $options['edit_photo'];
        $editPassword = $options['edit_password'];
        $operateur = $options['operateur'];

        $builder

            ->add('lastname', TextType::class, [
                'row_attr'=>['class'=>'mb-3'],
                
                'label'=>'Nom',
                'required'=>true,
                
                'attr' => ['class' => 'form-control'],
            ])

            
            ->add('firstname', TextType::class, [
                'row_attr'=>['class'=>'mb-3'],

                'label'=>'Prénom',
                'required'=>true,

                'attr' => ['class' => 'form-control'],
            ]);

            

            if ($operateur == false) {

                
                $builder->add('age', IntegerType::class, [
                    'row_attr'=>['class'=>'mb-3'],
    
                    'label'=>'Age',
                    'required'=>true,
    
                    'attr' => ['class' => 'form-control'],
                ])
                
                ->add('gender', ChoiceType::class, [
                    'choices'  => [
                        'Homme' => 0,
                        'Femme' => 1
                    ],
    
                    'expanded'=>true,
    
                    'row_attr'=>['class'=>'mb-3'],
                    
                    'label'=>'Genre',
                    'required'=>true,
                    
                    'attr' => ['class' => 'd-bloc gender-bloc-choices'],
    
    
                ])
                
                
                ->add('country', EntityType::class, [
                    'class' => Countries::class,
                     
                    'choice_label' => 'name',
    
                    'label'=>'Pays de résidence',
                    'required'=>true,
    
                    'attr' => ['class' => 'form-control'],
                    'row_attr'=>['class'=>'mb-3'],
                ])
    
    
                ->add('ville', TextType::class, [
                    'row_attr'=>['class'=>'mb-3'],
    
                    'label'=>'Ville de résidence',
                    'required'=>true,
    
                    'attr' => ['class' => 'form-control'],
                    'row_attr'=>['class'=>'mb-3'],
                ])
    
    
                ->add('originTown', EntityType::class, [
                    'class' => Region::class,
                     
                    'choice_label' => 'name',
    
                    'label'=>"ville d'origine",
                    'required'=>true,
    
                    'attr' => ['class' => 'form-control'],
                    'row_attr'=>['class'=>'mb-3'],
                ])
    
                
                ->add('profession', TextType::class, [
                    'row_attr'=>['class'=>'mb-3'],
    
                    'label'=>'Profession',
                    'required'=>true,
    
                    'attr' => ['class' => 'form-control'],
                ]);
            }




            $builder->add('email', EmailType::class, [
                'row_attr'=>['class'=>'mb-3'],
                
                'label'=>'E-mail',
                'required'=>true,
                
                'attr' => ['class' => 'form-control'],
            ]);



            
            if ( $editPassword == true ) {
                $builder->add('password', PasswordType::class, [
                    'row_attr'=>['class'=>'mb-3'],
                    
                    'label'=>'Mot de passe',
                    'required'=>true,
                    
                    'attr' => ['class' => 'form-control'],
                ]);
            }


            if ( $editPhoto == true ) {
                $builder->add('photoURL', FileType::class, [
                    'row_attr'=>['class'=>'mb-3'],
                    'mapped'=>false,
                    'label'=>'Photo',
                    'required'=>false,
    
                    'attr' => ['class' => 'form-control'],
                ]);
            }
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'edit_password'=>true,
            'edit_photo'=>false,
            'operateur'=>false
        ]);

    }
}
