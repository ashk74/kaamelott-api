<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiService
{
    public function __construct(private HttpClientInterface $client)
    {
    }

    /**
     * Get data from the API
     *
     * @param string $endpoint API endpoint to call
     *
     * @return array $response
     */
    public function get(string $endpoint): array
    {
        $response = $this->client->request('GET', 'https://kaamelott.chaudie.re/api/' . $endpoint);

        return $response->toArray();
    }

    /**
     * Get a random quote from the API
     *
     * @return array $response
     */
    public function randomQuote(): array
    {
        return $this->get('random');
    }

    /**
     * Get all quotes from the API
     *
     * @return array $response
     */
    public function allQuotes(): array
    {
        return $this->get('all');
    }

    /**
     * Get all characters from the API
     *
     * @return array $characters
     */
    public function getCharacters(): array
    {
        // Get all quotes
        $quotes = $this->allQuotes();

        // Get all characters
        for ($i = 0; $i < count($quotes['citation']); $i++) {
            $characters[] = $quotes['citation'][$i]['infos']['personnage'];
        }

        // Remove duplicates
        $characters = array_unique($characters);

        return $characters;
    }

    /**
     * Get all images from the API
     *
     * @return array $images
     */
    public function getImages(): array
    {
        $images = [];
        // Get all characters
        foreach ($this->getCharacters() as $character) {
            // Get image
            $response = $this->client->request('GET', 'https://kaamelott.chaudie.re/api/personnage/' . $character . '/pic');

            // If the response is not an image, use a placeholder
            if (json_decode($response->getContent(), true)) {
                $images[$character] = 'https://place-hold.it/250x250.png?text=' . $character . '&italic&fontsize=22';
            } else {
                $images[$character] = 'https://kaamelott.chaudie.re/api/personnage/' . $character . '/pic';
            }
        }

        return $images;
    }
}
