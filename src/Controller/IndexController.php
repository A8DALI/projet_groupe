<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ConnexionType;
use App\Form\ContactType;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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

                $this->addFlash('success', 'Vous êtes bien enregistré, connectez vous pour profiter du site !');

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

        //l'identifiant saisi en cas de mauvaise authentification
        $lastUsername = $authenticationUtils->getLastUsername();

        if(!empty($error)){
            $this->addFlash('error', 'Identifiants incorrects');
        }


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

    /**
     * @Route("/contact")
     */
    public function contact(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType::class);

        if(!is_null($this->getUser())){
            $form->get('nom')->setData($this->getUser());
            $form->get('email')->setData($this->getUser()->getEmail());
        }

        $form->handleRequest($request);

        if($form->isSubmitted()) {

            if ($form->isValid()) {


                $data = $form->getData();

                $mail = new Email();

                $messageModele = $this->renderView('index/contact_modele.html.twig',
                    [
                        'data' => $data
                    ]);

                $mail
                    ->html($messageModele)
                    ->from('')
                    ->to('')
                    ->replyTo($data['email']);

                $mailer->send($mail);

                $this->addFlash('success', 'Votre message a bien été envoyé');

                return $this->redirectToRoute('/');

            } else {

                $this->addFlash('error', 'le formulaire contient des erreurs');
            }
        }

        return $this->render('index/contact.html.twig',
        [
            'form'=>$form->createView()
        ]);
    }
}
