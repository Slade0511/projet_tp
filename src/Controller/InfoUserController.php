<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class InfoUserController extends AbstractController
{
    /**
     * @Route("/info-user", name="info_user")
     */
    public function index(Request $request): Response
    {
        // Créez un formulaire simple
        $form = $this->createFormBuilder()
        ->add('nom', null, ['label' => 'Nom'])
        ->add('prenom', null, ['label' => 'Prénom'])
        ->add('date_naissance', DateType::class, [
            'label' => 'Date de naissance',
            'widget' => 'single_text',
            'html5' => true, // Utiliser le support HTML5 natif
            'format' => 'yyyy-MM-dd', // Format pour la valeur "value" (ce qui sera envoyé au serveur)
        ])
        ->add('genre', \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class, [
            'label' => 'Genre',
            'choices' => [
                'Homme' => 'Homme',
                'Femme' => 'Femme',
                'Non binaire' => 'Non binaire',
            ],
        ])
        ->getForm();

        // Gérez la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Traitez les données du formulaire (par exemple, enregistrez-les dans la base de données)
            $data = $form->getData();
            dump($data); // Faites quelque chose avec les données (remplacez par votre logique)
        }

        // Affichez le formulaire dans la vue
        return $this->render('info_user/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
