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


//			$users = $repository->findAll();

			$Loggeduser = $this->getUser();

			$suggestions = $repository->findBy(
				[
					'ville' => $Loggeduser->getVille(),
					'genre' => $Loggeduser->getGenre()
				],
				[
					//pour passer le limit à 3
				],
				3
			);

			return $this->render(
				'suggestion/index.html.twig',
				[
					'suggestions' => $suggestions
				]
			);
		}



//		public function getLoggedUser(EntityManagerInterface $manager)
//		{
//			$this->denyAccessUnlessGranted('ROLE_USER');
//			$user = $this->getUser();
//
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