<?php

	namespace App\Controller;

	use App\Repository\UserRepository;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\Routing\Annotation\Route;

	/**
	 * @Route("/propositions")
	 */
	class UserController extends AbstractController
	{
		/**
		 * @Route("/")
		 */
		public function index(UserRepository $repository)
		{
			$users = $repository->findAll();

			return $this->render(
				'user/index.html.twig',
				[
					'users' => $users
				]
			);
		}
	}
