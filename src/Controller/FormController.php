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
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $habitantsRepository = $entityManager->getRepository(Habitant::class);
        $habitants = $habitantsRepository->findAll();

        foreach ($habitants as $habitant) {
            $dateNaissance = $habitant->getDateDeNaissance();
    
            
        }

        // Trie les habitants par ordre alphabétique du nom de famille
        usort($habitants, function ($a, $b) {
            return strcmp($a->getNom(), $b->getNom());
        });

        $idToDelete = $request->get('delete_id');
        if ($idToDelete > 0) {
            $this->deleteHabitant($idToDelete, $entityManager);
            $habitants = $habitantsRepository->findAll();
        }        

        
        return $this->render('form/index.html.twig', [
            'habitants' => $habitants,
        ]);

       

        
    }

function deleteHabitant(int $id, EntityManagerInterface $entityManager) {


// Récupérez l'entité Habitant par son identifiant
$habitant = $entityManager->getRepository(Habitant::class)->find($id);

// Vérifiez si l'entité existe
if (!$habitant) {
    throw $this->createNotFoundException('Habitant non trouvé');
}

// Supprimez l'entité
$entityManager->remove($habitant);
$entityManager->flush();

 
}

function editHabitantAction(int $id, EntityManagerInterface $entityManager): JsonResponse
{
   $id = $request->request->get('id');
   $nom = $request->request->get('nom');
   $prenom = $request->request->get('prenom');
   $dateNaissance = $request->request->get('date_naissance');
   $genre = $request->request->get('genre');

   // Récupérez l'habitant depuis la base de données
   

   // Enregistrez les modifications dans la base de données
   $entityManager->flush();

   // Répondez avec un succès
   return new JsonResponse(['message' => 'Habitant mis à jour avec succès']);
}

/**
 * @Route("/delete-habitant/{id}", name="delete_habitant", methods={"POST"})
 */    


    /*public function index(): Response
    {
        return $this->render('form/index.html.twig', [
            'controller_name' => 'FormController',
        ]);
    }*/

}
