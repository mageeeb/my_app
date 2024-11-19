<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    #[Route('/home', name: 'app_homepage')]
    public function index(): Response
    {
        return $this->render('homepage/list.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }
}
