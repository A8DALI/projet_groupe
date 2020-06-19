<?php

	namespace App\Controller;

	use App\Repository\UserRepository;
	use Symfony\Component\HttpFoundation\Response;
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

		/**
		 * @Route("/suggestions/plus")
		 */
		public function plusDeSuggestions(UserRepository $repository)
		{

			$offset = $_GET['getresult'];

			$Loggeduser = $this->getUser();

			$suggestions = $this->getDoctrine()->getRepository("App:User")->findByVilleEtGenre($Loggeduser, $offset);

			if (empty($suggestions)) {
				return new Response('erreur');
			}

			return $this->render('plusdesuggestions/index.html.twig',
				[
					'suggestions' => $suggestions
				]);
		}

		/**
		 * @Route("/suggestion/profil/{id}")
		 */
		public function profilSuggestion(UserRepository $repository, $id)
		{
			$profilSuggestion = $repository->find($id);


			return $this->render('suggestion/profil.html.twig',
				[
					'profilsuggestion' => $profilSuggestion
				]);

		}
	}