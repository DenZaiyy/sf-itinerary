<?php

namespace App\Controller;

use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ItineraryController extends AbstractController
{

    public function __construct(
        private readonly ApiService $apiService
    ){}

    #[Route('/', name: 'itinerary_index')]
    public function index(): Response
    {
        $itineraries = $this->apiService->getItineraries();
        return $this->render('itinerary/index.html.twig', [
            'itineraries' => $itineraries,
        ]);
    }

    #[Route('/itinerary/{id}', name: 'itinerary_show')]
    public function itinerary(string $id): Response
    {
        $itinerary = $this->apiService->getItinerary($id);
        return $this->render('itinerary/show.html.twig', [
            'itinerary' => $itinerary,
        ]);
    }
}
