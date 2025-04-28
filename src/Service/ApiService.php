<?php

namespace App\Service;

use Symfony\Component\HttpClient\CachingHttpClient;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiService {

    public function __construct(
        // HttpClientInterface est une interface qui permet de faire des requêtes HTTP
        private HttpClientInterface $client,
        // $targetStore est une variable qui permet de stocker les données en cache
        // La variable est généré depuis le fichier config "services.yaml"
        private $targetStore,
        // $nextApiUrl est l'url de l'API Next.js qui est récupérer par le service.yaml et le fichier .env
        private readonly string $nextApiUrl,
    )
    {
        // Mise en place du cache pour les requêtes HTTP
        $store = new Store($this->targetStore);
        // Création d'un client HTTP avec le cache
        $this->client = HttpClient::create();
        // Création d'un client HTTP avec le cache
        $this->client = new CachingHttpClient($this->client, $store);
    }

    private function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
        ];
    }

    public function getItineraries(): array
    {
        // Utilisation d'un try-catch pour gérer les exceptions lors de la requête
        try {
            // Exécution de la requête GET pour récupérer les itinéraires avec la méthode request
            $response = $this->client->request('GET', $this->nextApiUrl . "/api/itineraries", [
                'headers' => $this->getHeaders(),
            ]);

            // Conversion de la réponse en tableau
            $data = $response->toArray();
        } catch (TransportExceptionInterface $e) {
            // Gestion de l'exception en affichant le message d'erreur
            echo $e->getMessage();
            // Si une exception est levée, on retourne un tableau vide
            $data = [];
        }

        // Retourne les données récupérées
        return $data;
    }

    public function createItinerary(array $data): array
    {
        try {
            $response = $this->client->request('POST', $this->nextApiUrl . "/api/itineraries", [
                'headers' => $this->getHeaders(),
                'json' => $data,
            ]);

            $data = $response->toArray();
        } catch (TransportExceptionInterface $e) {
            echo $e->getMessage();
            $data = [];
        }

        return $data;
    }

    public function getItinerary(string $id): array
    {
        // Utilisation d'un try-catch pour gérer les exceptions lors de la requête
        try {
            // Exécution de la requête GET pour récupérer un itinéraire avec son ID depuis la méthode request
            $response = $this->client->request('GET', $this->nextApiUrl . "/api/itineraries/" . $id, [
                'headers' => $this->getHeaders(),
            ]);

            // Conversion de la réponse en tableau
            $data = $response->toArray();
        } catch (TransportExceptionInterface $e) {
            // Affichage du message d'erreur le cas échéant
            echo $e->getMessage();
            // Si une exception est levée, on retourne un tableau vide
            $data = [];
        }

        // Retourne les données récupérées
        return $data;
    }

    public function updateItinerary(string $id, array $data): array
    {
        // Utilisation d'un try-catch pour gérer les exceptions lors de la requête
        try {
            // Exécution de la requête PUT pour mettre à jour un itinéraire avec son ID
            // Envoie des données à mettre à jour dans le corps de la requête
            $response = $this->client->request('PUT', $this->nextApiUrl . "/api/itineraries/" . $id, [
                'headers' => $this->getHeaders(),
                'json' => $data,
            ]);

            // Conversion de la réponse en tableau
            $data = $response->toArray();
        } catch (TransportExceptionInterface $e) {
            // Affichage du message d'erreur le cas échéant
            echo $e->getMessage();
            // Si une exception est levée, on retourne un tableau vide
            $data = [];
        }

        // Retourne les données récupérées
        return $data;
    }

    public function deleteItinerary(string $id): void
    {
        try {
            $response = $this->client->request('DELETE', $this->nextApiUrl . "/api/itineraries/" . $id, [
                'headers' => $this->getHeaders(),
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new NotFoundHttpException();
            }

        } catch (TransportExceptionInterface $e) {
            echo $e->getMessage();
        }
    }

    public function createLocation(array $data): array
    {
        try {
            $response = $this->client->request('POST', $this->nextApiUrl . '/api/locations', [
                'headers' => $this->getHeaders(),
                'json' => $data,
            ]);

            $data = $response->toArray();
        } catch (TransportExceptionInterface $e) {
            echo $e->getMessage();
            $data = [];
        }

        return $data;
    }

    public function getLocations(): array
    {
        try {
            $response = $this->client->request('GET', $this->nextApiUrl . '/api/locations', [
                'headers' => $this->getHeaders(),
            ]);

            $data = $response->toArray();
        } catch(TransportExceptionInterface $e) {
            echo $e->getMessage();
            $data = [];
        }

        return $data;
    }

    public function deleteLocationFromItinerary(string $itineraryId, string $locationId): void
    {
        try {
            $response = $this->client->request('DELETE', $this->nextApiUrl . "/api/itineraries/" . $itineraryId . "/" . $locationId, [
                'headers' => $this->getHeaders(),
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new NotFoundHttpException();
            }
        } catch (TransportExceptionInterface $e) {
            echo $e->getMessage();
        }

    }

    public function addToItinerary(array $data): array
    {
        try {
            $response = $this->client->request('POST', $this->nextApiUrl . '/api/location', [
                'headers' => $this->getHeaders(),
                'json' => $data
            ]);

            $data = $response->toArray();
        } catch (TransportExceptionInterface $e) {
            echo $e->getMessage();
            $data = [];
        }

        return $data;

    }
}
