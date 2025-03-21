<?php

namespace App\Controller;

use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{

    public function __construct(
        private ApiService $apiService
    )
    {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $itineraries = $this->apiService->getItineraries();
        return $this->render('home/index.html.twig', [
            'itineraries' => $itineraries,
        ]);
    }

    #[Route('/itinerary/{id}', name: 'app_itinerary')]
    public function itinerary(string $id): Response
    {
        $itinerary = $this->apiService->getItinerary($id);
        return $this->render('home/show.html.twig', [
            'itinerary' => $itinerary,
        ]);
    }
}
