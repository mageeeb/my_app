<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Etudiant;
use Doctrine\ORM\EntityManagerInterface;

class EtudiantContoller extends AbstractController
{
    #[Route('/etudiants', name: 'etudiants_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        // Récupération de tous les étudiants
        $etudiants = $entityManager->getRepository(Etudiant::class)->findAll();

        // Transmission des étudiants à la vue
        return $this->render('etudiant/list.html.twig', [
            'etudiants' => $etudiants, // Cette ligne transmet "etudiants" à la vue Twig
        ]);
    }
}
