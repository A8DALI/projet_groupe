<?php

	namespace App\Controller;

	use App\Entity\User;
	use App\Repository\UserRepository;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\Routing\Annotation\Route;

	class SuggestionController extends AbstractController
	{
		/**
		 * @Route("/suggestions")
		 */
		public function index(UserRepository $repository)
		{
			$users = $repository->findAll();

			return $this->render(
				'suggestion/index.html.twig',
				[
					'users' => $users
				]
			);
		}



//		public function getLoggedUser(EntityManagerInterface $manager)
//		{
//			$this->denyAccessUnlessGranted('ROLE_USER');
//			$user = $this->getUser();
//
//			print_r($this->getu)
//		}
//
//		public function LoggedUserDetails()
//		{
//			$userId= $this->getLoggedUser()->getid();
//			$userVille= $this->getLoggedUser()->();
//			$userId= $this->getLoggedUser()->getUsername();
//
//
//
//
//		}
	}