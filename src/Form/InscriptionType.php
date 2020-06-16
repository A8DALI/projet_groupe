<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\User;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo',
                TextType::class,
                [
                    'label' => 'Pseudo'
                ]

            )
            ->add('email',
                EmailType::class,
                [
                    'label' => 'E-mail'
                ]
            )
            ->add('mdpClair',
                RepeatedType::class,
                [
                    'type'=>PasswordType::class,
                    'first_options' => [
                        'label' => 'Mot de passe',
                    ],
                   'second_options' => [
                       'label' => 'Confirmation du mot de passe'
                   ],
                   'invalid_message' => 'La confirmation ne correspond pas au mot de passe'
                ]

            )
            //->add('role')
            ->add('ville',
            EntityType::class,
                [
                    'label' => 'Votre ville',
                    'required' => true,
                    'class' => Ville::class,
                    'choice_label' => 'nom',
                    'placeholder' => 'Choisissez une ville'
                ]

            )
            ->add('genre',
            EntityType::class,
                [
                    'label' => 'Votre genre de film préféré',
                    'required' => true,
                    'class' => Genre::class,
                    'choice_label' => 'type',
                    'placeholder' => 'Choisissez un genre'
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
