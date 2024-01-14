<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Habitant;
use Psr\Log\LoggerInterface;

class InfoUserController extends AbstractController
{
    /**
     * @Route("/info-user", name="info_user")
     */
    
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        
        // Créez un formulaire simple
        $form = $this->createFormBuilder()
            ->add('nom', null, ['label' => 'Nom'])
            ->add('prenom', null, ['label' => 'Prénom'])
            ->add('date_naissance', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'html5' => true,
                'format' => 'yyyy-MM-dd',
            ])
            ->add('genre', \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class, [
                'label' => 'Genre',
                'choices' => [
                    'Homme' => 'Masculin',
                    'Femme' => 'Féminin',
                    'Non binaire' => 'Non binaire',
                    'Autre' => 'Autre',
                ],
            ])
            ->getForm();

        // Gérez la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Traitez les données du formulaire
            $data = $form->getData();
            // Créez un nouvel objet Habitant
            $habitant = new Habitant();
            $habitant->setNom($data['nom']);
            $habitant->setPrenom($data['prenom']);
            $habitant->setDateDeNaissance($data['date_naissance']->format('Y-m-d'));
            $habitant->setGenre($data['genre']);

            // Enregistrez l'habitant dans la base de données
            $entityManager->persist($habitant);
            $entityManager->flush();

            // Affichez un message de succès ou redirigez l'utilisateur
            $this->addFlash('success', 'Habitant créé avec succès');
            //return $this->redirectToRoute('form');
        }

        // Affichez le formulaire dans la vue
        return $this->render('info_user/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
