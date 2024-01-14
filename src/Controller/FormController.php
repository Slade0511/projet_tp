<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Habitant;
use Doctrine\ORM\EntityManagerInterface;

class FormController extends AbstractController
{
    
    #[Route('/form', name: 'app_form')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupère tous les habitants depuis la base de données
        $habitantsRepository = $entityManager->getRepository(Habitant::class);
        $habitants = $habitantsRepository->findAll();

        // Formate les dates de naissance dans le format JJ/MM/AAAA
        foreach ($habitants as $habitant) {
            $dateNaissance = $habitant->getDateDeNaissance();
        }

        // Trie les habitants par ordre alphabétique du nom de famille
        usort($habitants, function ($a, $b) {
            return strcmp($a->getNom(), $b->getNom());
        });

        return $this->render('form/index.html.twig', [
            'habitants' => $habitants,
        ]);
    }

    public function validerModifications(Request $request): Response
    {
        // Code pour traiter les modifications (enregistrement dans la base de données, par exemple)
        
        // Redirigez l'utilisateur vers la page d'accueil après la validation
        return $this->redirectToRoute('home');
    }

/**
 * @Route("/delete-habitant/{id}", name="delete_habitant", methods={"POST"})
 */    

     public function deleteHabitant($id): Response
    {
        // Récupérez le gestionnaire d'entités
        $entityManager = $this->getDoctrine()->getManager();

        // Récupérez l'entité Habitant par son identifiant
        $habitant = $entityManager->getRepository(Habitant::class)->find($id);

        // Vérifiez si l'entité existe
        if (!$habitant) {
            throw $this->createNotFoundException('Habitant non trouvé');
        }

        // Supprimez l'entité
        $entityManager->remove($habitant);
        $entityManager->flush();

        // Vous pouvez rediriger vers une autre page ou afficher un message de confirmation
        return $this->redirectToRoute('page_de_confirmation');
    }
    /*public function index(): Response
    {
        return $this->render('form/index.html.twig', [
            'controller_name' => 'FormController',
        ]);
    }*/
}
