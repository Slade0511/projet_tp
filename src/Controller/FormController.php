<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Habitant;

class FormController extends AbstractController
{
    
    #[Route('/form', name: 'app_form')]
    public function index(): Response
    {
        // Crée 10 habitants au hasard
        $habitants = [];
        for ($i = 0; $i < 10; $i++) {
            $habitants[] = $this->createRandomHabitant();
        }

        // Trie les habitants par ordre alphabétique du nom de famille
        usort($habitants, function ($a, $b) {
            return strcmp($a->getNom(), $b->getNom());
        });

        return $this->render('form/index.html.twig', [
            'habitants' => $habitants,
        ]);
    }

    private function createRandomHabitant(): Habitant
    {
        $faker = \Faker\Factory::create();

        $habitant = new Habitant();
        $habitant->setNom($faker->lastName);
        $habitant->setPrenom($faker->firstName);
        $habitant->setDateDeNaissance($faker->date('d/m/Y'));
        $habitant->setGenre($faker->randomElement(['Homme', 'Femme']));

        return $habitant;
    }
    public function validerModifications(Request $request): Response
    {
        // Code pour traiter les modifications (enregistrement dans la base de données, par exemple)
        
        // Redirigez l'utilisateur vers la page d'accueil après la validation
        return $this->redirectToRoute('home');
    }
    /*public function index(): Response
    {
        return $this->render('form/index.html.twig', [
            'controller_name' => 'FormController',
        ]);
    }*/
}
