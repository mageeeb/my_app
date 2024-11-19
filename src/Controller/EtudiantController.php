<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; // N'oubliez pas cet import
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Etudiant;
use App\Form\EtudiantType; // Assurez-vous que ce type existe
use Doctrine\ORM\EntityManagerInterface;

class EtudiantController extends AbstractController
{
    #[Route('/etudiants', name: 'etudiants_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $etudiants = $entityManager->getRepository(Etudiant::class)->findAll();

        return $this->render('etudiant/list.html.twig', [
            'etudiants' => $etudiants,
        ]);
    }

    #[Route('/etudiants/new', name: 'etudiant_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);

        $form->handleRequest($request);

        if ($etudiant->getImage()) {
            $photo = $form->get('image')->getData();
            if ($photo) {
                $newFilename = uniqid() . '.' . $photo->guessExtension();

                // Déplacer l'image dans le répertoire uploads
                $photo->move(
                    $this->getParameter('uploads_directory'),
                    $newFilename
                );

                // Mettre à jour la propriété `image`
                $etudiant->setImage($newFilename);
            }

            $entityManager->persist($etudiant);
            $entityManager->flush();

            return $this->redirectToRoute('etudiants_list');
        }

        return $this->render('etudiant/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/etudiants/{id}', name: 'etudiant_show', requirements: ['id' => '\d+'])]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'étudiant par son ID
        $etudiant = $entityManager->getRepository(Etudiant::class)->find($id);

        // Gérer le cas où l'étudiant n'existe pas
        if (!$etudiant) {
            throw $this->createNotFoundException('Étudiant non trouvé.');
        }

        // Renvoyer les détails de l'étudiant à une vue
        return $this->render('etudiant/show.html.twig', [
            'etudiant' => $etudiant,
        ]);
    }
}