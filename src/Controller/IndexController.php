<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class IndexController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder,
                    EntityManagerInterface $manager)
    {
        $user = new User();

        $form = $this-> createForm(InscriptionType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted()){

            if($form->isValid()){
                $encodePassword = $passwordEncoder->encodePassword(
                    $user,
                    $user->getMdpClair()
                    );

               $user->setMdp($encodePassword);

                $manager->persist($user);
                $manager->flush();

                // On peut mettre le auto-login ici

                //$this->addFlash('sucess', 'Vous êtes bien enregistré');

                return $this->redirectToRoute('app_suggestion_index');

            }
        }


        return $this->render('index/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
