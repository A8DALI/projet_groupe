<?php


namespace App\Controller\Admin;

use App\Entity\Genre;
use App\Entity\Ville;
use App\Form\GenreType;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/genre")
 */
class GenreController extends AbstractController
{

    /**
     * @Route("/{id}", defaults={"id":null})
     */
    public function index(GenreRepository $repository, EntityManagerInterface $manager, Request $request, $id)
    {
        $genres = $repository->findAll();

        if(is_null($id)){
            $genre = new Genre();
        } else {
            $genre = $repository->find($id);

            $this->addFlash('info', 'Modifiez dans le champ de saisie et validez');
        }

        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manager->persist($genre);
            $manager->flush();

            $this->addFlash('success', 'Enregistrement réussi !');

            return $this->redirectToRoute('app_admin_genre_index');

        }

        return $this->render('admin/genre/index.html.twig',
        [
            'genres' => $genres,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/suppression/{id}")
     */
    public function efface(EntityManagerInterface $manager, Genre $genre)
    {
        $manager->remove($genre);
        $manager->flush();

        $this->addFlash('success', 'Genre bien effacé');

        return $this->redirectToRoute('app_admin_genre_index');
    }


}