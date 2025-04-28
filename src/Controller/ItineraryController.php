<?php

namespace App\Controller;

use App\Form\ItineraryType;
use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ItineraryController extends AbstractController
{

    public function __construct(private readonly ApiService $apiService)
    {
    }

    #[Route('/', name: 'itinerary_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('itinerary/index.html.twig', [
            // Récupération des itinéraires gérer sur l'API depuis le service ApiService
            'itineraries' => $this->apiService->getItineraries(),
        ]);
    }

    #[Route('/itinerary/{id}', name: 'itinerary_show', methods: ['GET'], priority: -1)]
    public function show(string $id): Response
    {
        return $this->render('itinerary/show.html.twig', [
            // Renvoyer les données à la vue pour afficher le détail d'un itinéraire depuis son ID
            'itinerary' => $this->apiService->getItinerary($id),
        ]);
    }

    #[Route('/itinerary/add', name: 'itinerary_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        // Récupération des lieux gérer sur l'API depuis le service ApiService
        $locations = $this->apiService->getLocations();

        // Initialisation du tableau de choix pour le formulaire
        $locationsChoices = [];

        // Remplissage du tableau de choix avec les lieux récupérés
        foreach ($locations as $location) {
            $locationsChoices[$location['name']] = $location['id'];
        }

        // Création du formulaire pour ajouter un nouvel itinéraire avec les choix de lieux en options
        $form = $this->createForm(ItineraryType::class, null, [
            'locations_choices' => $locationsChoices
        ]);

        // Traitement de la requête du formulaire
        $form->handleRequest($request);

        // Vérification si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération des données du formulaire
            $data = $form->getData();

            // Vérification si l'itinéraire a été créé avec succès
            if ($this->apiService->createItinerary($data)) {
                // Si l'itinéraire a été créé, on ajoute un message flash de succès
                $this->addFlash('success', 'Itinerary added successfully');
                // On redirige vers la page d'index des itinéraires
                return $this->redirectToRoute('itinerary_index');
            }
        }

        // On renvoie le formulaire à la page de la route '/itinerary/add'
        return $this->render('itinerary/new.html.twig', [
            "form" => $form->createView(),
        ]);
    }

    #[Route('/itinerary/{id}/delete', name: 'itinerary_delete', methods: ['DELETE'])]
    public function delete(string $id): Response
    {
        // Vérification si l'ID de l'itinéraire est présent
        if (!$id) {
            // Si l'ID n'est pas trouvé, on redirige vers la page d'index avec un message d'erreur
            $this->addFlash('error', 'Itinerary id not found');
            // On redirige vers la page d'index des itinéraires
            return $this->redirectToRoute('itinerary_index');
        }
        // Suppression de l'itinéraire avec l'ID spécifié
        $this->apiService->deleteItinerary($id);
        // Ajout d'un message flash de succès
        $this->addFlash('success', 'Itinerary deleted successfully');
        // Redirection vers la page d'index des itinéraires
        return $this->redirectToRoute('itinerary_index');
    }

    #[Route('/itinerary/{id}/update', name: 'itinerary_update', methods: ['PUT', 'POST'])]
    public function update(Request $request, string $id): Response
    {
        if (!$id) {
            return new JsonResponse(['error' => 'Itinerary id not found'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

            $result = $this->apiService->updateItinerary($id, $data);

            if($result) {
                return new JsonResponse(['success' => true, 'message' => 'Itinerary updated successfully']);
            }

            return new JsonResponse(['error' => 'Itinerary update failed'], Response::HTTP_BAD_REQUEST);
        } catch (\JsonException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
