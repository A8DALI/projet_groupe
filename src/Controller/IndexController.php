<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ConnexionType;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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

                $this->addFlash('sucess', 'Vous êtes bien enregistré, connectez vous pour profiter du site !');

                return $this->redirectToRoute('app_index_index');

            }
        }
        return $this->render('index/index.html.twig', [
            'form' => $form->createView(),
        ]);


    }

    /**
     * @Route("/connexion")
     */
    public function connexion(AuthenticationUtils $authenticationUtils)
    {

            $error = $authenticationUtils->getLastAuthenticationError();
            $lastUsername = $authenticationUtils->getLastUsername();

            if (!empty($error)) {

                $this->addFlash('error', 'Identifiants incorrects');

            }

            $this->addFlash('success', 'Vous êtes connecté');

            return $this->redirectToRoute('app_suggestion_index',
                [
                    'last_username' => $lastUsername
                ]);

    }

    /**
     * @Route("/deconnexion")
     */
    public function logout()
    {
        //cette méthode peut rester vide, il faut juste que sa route
        //existe et soit configurée dans la partie logout dans
        //config/packages/security.yaml
    }
}
