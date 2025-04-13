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
        private HttpClientInterface $client,
        private $targetStore,
        private readonly string $nextApiUrl,
    )
    {
        $store = new Store($this->targetStore);
        $this->client = HttpClient::create();
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
        try {
            $response = $this->client->request('GET', $this->nextApiUrl . "/api/itineraries", [
                'headers' => $this->getHeaders(),
            ]);

            $data = $response->toArray();
        } catch (TransportExceptionInterface $e) {
            echo $e->getMessage();
            $data = [];
        }

        return $data;
    }

    public function createItinerary(array $data): array
    {
        try {

            //dd($data);
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
        try {
            $response = $this->client->request('GET', $this->nextApiUrl . "/api/itineraries/" . $id, [
                'headers' => $this->getHeaders(),
            ]);

            $data = $response->toArray();
        } catch (TransportExceptionInterface $e) {
            echo $e->getMessage();
            $data = [];
        }

        return $data;
    }

    public function updateItinerary(string $id, array $data): array
    {
        try {
            $response = $this->client->request('PUT', $this->nextApiUrl . "/api/itineraries/" . $id, [
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
