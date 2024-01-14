<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
   // #[Route('/api', name: 'app_api')]
   public function createHabitant(Request $request, EntityManagerInterface $entityManager): JsonResponse
   {
       $data = json_decode($request->getContent(), true);

       // Vérifiez que les données nécessaires sont présentes
       if (!isset($data['nom'], $data['prenom'], $data['date_naissance'], $data['genre'])) {
           return new JsonResponse(['error' => 'Missing data'], JsonResponse::HTTP_BAD_REQUEST);
       }

       // Créez un nouvel objet Habitant
       $habitant = new Habitant();
       $habitant->setNom($data['nom']);
       $habitant->setPrenom($data['prenom']);
       $habitant->setDateNaissance($data['date_naissance'].toString());
       $habitant->setGenre($data['genre']);

       // Enregistrez l'habitant dans la base de données
       $entityManager->persist($habitant);
       $entityManager->flush();

       return new JsonResponse(['message' => 'Habitant créé avec succès'], JsonResponse::HTTP_CREATED);
   }

   
}
