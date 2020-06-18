<?php

	namespace App\Controller;

//	use App\Entity\User;
	use App\Repository\UserRepository;
//	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\Routing\Annotation\Route;

	class SuggestionController extends AbstractController
	{
		/**
		 * @Route("/suggestions")
		 */
		public function index(UserRepository $repository)
		{

			$Loggeduser = $this->getUser();

			$suggestions = $this->getDoctrine()->getRepository("App:User")->findByVilleEtGenre($Loggeduser);

			return $this->render(
				'suggestion/index.html.twig',
				[
					'suggestions' => $suggestions
				]
			);
//			$users = $repository->findAll();
//			$Loggeduser = $this->getUser();
//			$suggestions = $repository->findBy(
//				[
//					'ville' => $Loggeduser->getVille(),
//					'genre' => $Loggeduser->getGenre()
//				],
//				[
//					//pour passer le limit à 3
//				],
//				3
//			);
//
//			return $this->render(
//				'suggestion/index.html.twig',
//				[
//					'suggestions' => $suggestions
//				]
//			);
		}
	}