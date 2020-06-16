<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SuggestionController extends AbstractController
{
    /**
     * @Route("/suggestions")
     */
    public function index(UserRepository $repository)
    {
		$users = $repository->findAll();

		return $this->render(
			'suggestion/index.html.twig',
			[
				'users' => $users
			]
		);
	}
}