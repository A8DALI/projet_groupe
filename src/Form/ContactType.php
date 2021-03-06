<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'nom',
                TextType::class,
                [
                    'label' => 'Nom',
                    'constraints' => [
                        new NotBlank([
                            'message'=>'Le nom est obligatoire'
                        ])
                    ]

                ]

            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'Email',
                    'constraints' => [
                        new NotBlank([
                            'message'=>'Le mail est obligatoire'
                        ])
                    ]

                ]

            )
            ->add(
                'body',
                TextareaType::class,
                [
                    'label' => 'Votre message',
                    'constraints' => [
                        new NotBlank([
                            'message'=>'Le message est vide'
                        ])
                    ]

                ]

            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
