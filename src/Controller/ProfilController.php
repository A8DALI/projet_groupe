<?php

	namespace App\Controller;

	use App\Entity\User;
	use App\Form\ModificationType;
	use App\Repository\UserRepository;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\File\File;
	use Symfony\Component\HttpFoundation\File\UploadedFile;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Session\SessionInterface;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
	use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

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
		public function edit(Request $request,
							 EntityManagerInterface $manager,
							 UserRepository $repository)
		{
			$originalImage = null;

			$user = $this->getUser();
//			$user = $repository->find($id);

			$details = $manager->find(User::class, $user);

			if (!is_null($details->getImage())) {
				// nom du fichier venant de la bdd
				$originalImage = $details->getImage();

				// le champ de formulaire attend un objet File
				// utilisant le chemin vers le fichier
				$details->setImage(
					new File($this->getParameter('upload_dir') . $details->getImage())
				);
			}

			$form = $this->createForm(ModificationType::class, $details);

			$form->handleRequest($request);

			if ($form->isSubmitted()) {
				if ($form->isValid()) {
					/** @var UploadedFile|null $image */
					$image = $details->getImage();

					// si une image a été uploadée
					if (!is_null($image)) {
						// nom sous lequel on va enregistrer l'image
						$filename = uniqid() . '.' . $image->guessExtension();

						// déplacement de l'image uploadée
						$image->move(
						// dans quel répertoire
						// cf config/services.yaml
							$this->getParameter('upload_dir'),
							// nom du fichier
							$filename
						);

						// pour enregistrer le nom du fichier en bdd
						$details->setImage($filename);

						// en modification, suppression de l'ancienne image si l'article en avait une
						if (!is_null($originalImage)) {
							unlink($this->getParameter('upload_dir') . $originalImage);
						}
					} else {
						// en modification, sans upload,
						// on remets le nom de l'image venant de la bdd
						$details->setImage($originalImage);
					}

					$manager->persist($details);
					$manager->flush();

					$this->addFlash('success', "Votre profil est mis à jour");

					return $this->redirectToRoute('app_profil_index');
				} else {
					$this->addFlash('error', 'Le formulaire contient des erreurs');
				}
			}

			return $this->render('profil/edit.html.twig',
				[
//					'user' => $user,
					'details' => $details,
					'form' => $form->createView(),
					'original_image' => $originalImage
				]
			);

		}

		/**
		 * @Route("/suppression")
		 */
		public function delete(
			EntityManagerInterface $manager,
			TokenStorageInterface $tokenStorage,
			SessionInterface $session
		)
		{


			$user = $this->getUser();

//			// suppression de l'image de l'utilisateur s'il en a une
//			if (!is_null($user->getImage())) {
//				$image = $this->getParameter('upload_dir') . $user->getImage();
//				unlink($image);
//			}

			// suppression en bdd
			$manager->remove($user);
			$manager->flush();

			$tokenStorage->setToken(null);
			$session->invalidate();

			$this->addFlash('success', "Votre profil est supprimé");

			return $this->redirectToRoute('app_index_index');
		}

	}

