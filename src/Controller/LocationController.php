<?php

namespace App\Controller;

use App\Form\LocationType;
use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LocationController extends AbstractController
{

    public function __construct(
        private readonly ApiService $apiService,
    ){}

    #[Route('/location/add', name: 'location_new', methods: ["GET", "POST"])]
    public function new(Request $request): Response
    {
        $form = $this->createForm(LocationType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Location created successfully');
            $data = $form->getData();

            if($this->apiService->createLocation($data)) {
                $this->addFlash('success', 'Location created successfully');
                return $this->redirectToRoute('itinerary_index');
            }
        }

        return $this->render('location/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
