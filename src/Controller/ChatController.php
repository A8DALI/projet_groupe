<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Entity\User;
use App\Form\ChatType;
use App\Repository\MessagesRepository;
use Doctrine\DBAL\Driver\SQLSrv\LastInsertId;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ChatController extends AbstractController
{
    /**
     * @Route("/chat")
     */
    public function index()
    {

        return $this->render('chat/index.html.twig');
    }

    /**
     * @Route("/chat/traitement")
     */
    public function chatTraitement(EntityManagerInterface $manager)
    {

        if(!is_null($this->getUser())) {

            $messages = new Messages();

            $messages->setAuteur($this->getUser());
            $messages->setMessage($_POST['message']);

            $manager->persist($messages);
            $manager->flush();

            return $this->redirectToRoute('app_chat_index',
                [
                    'messages' => $messages
                ]);

        } else {

            $this->addFlash('info', 'Vous devez être connecté pour accéder au Chat');

            return $this->redirectToRoute('app_index_index');
        }

    }

    /**
     * @Route("/chat/affichage")
     */
    public function affichage(MessagesRepository $repository)
    {


        $messages = $repository->findBy([], ['id'=>'DESC'], 10);


        return $this->render('chat/affichage.html.twig',
        [
            'messages'=> $messages
        ]);
    }
}

