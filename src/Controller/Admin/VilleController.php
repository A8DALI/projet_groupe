<?php

namespace App\Controller\Admin;


use App\Entity\Ville;
use App\Form\VilleType;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ville")
 */
class VilleController extends AbstractController
{
    /**
     * @Route("/{id}", defaults={"id":null})
     */
    public function index(VilleRepository $repository, EntityManagerInterface $manager, Request $request, $id)
    {
        $villes = $repository->findAll();

        if(is_null($id)){
            $ville = new Ville();
        } else {
            $ville = $repository->find($id);

            $this->addFlash('info', 'Modifiez la ville dans le champ de saisi et validez');

        }


        $form = $this->createForm(VilleType::class, $ville);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manager->persist($ville);
            $manager->flush();

            $this->addFlash('success', 'Enregistrement réussi !');

            return $this->redirectToRoute('app_admin_ville_index');
        }

        return $this->render('admin/ville/index.html.twig',
        [
            'villes'=>$villes,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/suppression/{id}")
     */
    public function efface(EntityManagerInterface $manager, Ville $ville)
    {
        $manager->remove($ville);
        $manager->flush();

        $this->addFlash('success', 'Ville supprimée');

        return $this->redirectToRoute('app_admin_ville_index');
    }


}