<?php

namespace App\Controller;

use App\Form\ItineraryType;
use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ItineraryController extends AbstractController
{

    public function __construct(private readonly ApiService $apiService) {}

    #[Route('/', name: 'itinerary_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('itinerary/index.html.twig', [
            'itineraries' => $this->apiService->getItineraries(),
        ]);
    }

    #[Route('/itinerary/{id}', name: 'itinerary_show', methods: ['GET'], priority: -1)]
    public function show(string $id): Response
    {
        return $this->render('itinerary/show.html.twig', [
            'itinerary' => $this->apiService->getItinerary($id),
        ]);
    }

    #[Route('/itinerary/add', name: 'itinerary_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $form = $this->createForm(ItineraryType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Itinerary created successfully');
            $data = $form->getData();

            if($this->apiService->createItinerary($data)) {
                return $this->redirectToRoute('itinerary_index');
            }
        }

        return $this->render('itinerary/new.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
