<?php

	namespace App\Form;

	use App\Entity\Genre;
	use App\Entity\User;
	use App\Entity\Ville;
	use Symfony\Bridge\Doctrine\Form\Type\EntityType;
	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\Extension\Core\Type\EmailType;
	use Symfony\Component\Form\Extension\Core\Type\FileType;
	use Symfony\Component\Form\Extension\Core\Type\PasswordType;
	use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
	use Symfony\Component\Form\Extension\Core\Type\TextareaType;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\OptionsResolver\OptionsResolver;

	class ModificationType extends AbstractType
	{
		public function buildForm(FormBuilderInterface $builder, array $options)
		{
			$builder
				->add('pseudo',
					TextareaType::class,
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
						'type' => PasswordType::class,
						'first_options' => [
							'Nouveau mot de passe',
						],
						'second_options' => [
							'label' => 'Confirmation du nouveau mot de passe'
						],
						'invalid_message' => 'La confirmation ne correspond pas au mot de passe'
					]
				)
//				->add('role')
				->add('ville',
					EntityType::class,
					[
						'label' => 'Votre ville',
						'class' => Ville::class,
						'choice_label' => 'nom',
						'placeholder' => 'Choisissez une ville'
					]

				)
				->add('genre',
					EntityType::class,
					[
						'label' => 'Votre genre de film préféré',
						'class' => Genre::class,
						'choice_label' => 'type',
						'placeholder' => 'Choisissez un genre'
					]
				)
				->add('info',
					TextareaType::class,
					[
						'label' => 'Ajouter des détails supplémentaires à propos de vous',
						'required' => false
					]
				)
				->add('sexe',
					TextType::class,
					[
						'label' => 'Votre sexe',
						'required' => false

					]
				)
				->add('image',
					FileType::class,
					[
						'label' => 'Votre photo',
						'required' => false

					]
				);

		}

		public function configureOptions(OptionsResolver $resolver)
		{
			$resolver->setDefaults([
				'data_class' => User::class,
			]);
		}
	}
