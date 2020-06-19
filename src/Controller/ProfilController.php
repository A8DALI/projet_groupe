<?php

	namespace App\Controller;

	use App\Entity\User;
	use App\Repository\UserRepository;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\Routing\Annotation\Route;

	/**
	 * @Route("/profil")
	 */
	class ProfilController extends AbstractController
	{
		/**
		 * @Route("/")
		 */
		public function index(UserRepository $repository)
		{

			$LoggedUser = $this->getUser()->getId();

			$profil = $repository->findOneBy(
				[
					'id' => $LoggedUser
				]
			);

			return $this->render(
				'profil/index.html.twig',
				[
					'profil' => $profil
				]
			);
		}

		/**
		 * @Route("/edition")
		 */
		public function edit()
		{
			return $this->render('profil/edit.html.twig');
		}
	}

