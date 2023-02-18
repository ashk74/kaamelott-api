<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class ApiService to get data from the Kaamelott API
 *
 * @package App\Service
 *
 * @see https://github.com/sin0light/api-kaamelott
 */
class ApiService
{
    /**
     * ApiService constructor
     *
     * @param \Symfony\Contracts\HttpClient\HttpClientInterface $client
     */
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
     * Get all quotes from a character
     *
     * @param string $character Character name
     *
     * @return array $response
     */
    public function getQuotesByCharacter(string $character): array
    {
        return $this->get('all/personnage/' . $character);
    }

    /**
     * Get all quotes from a book
     *
     * @param int $book Book number
     *
     * @return array $response
     */
    public function getQuotesByBook(int $book): array
    {
        return $this->get('all/livre/' . $book);
    }

    /**
     * Get all quotes from the character in the book
     *
     * @param int $book Book number
     * @param string $character Character name
     *
     * @return array $response
     */
    public function getQuotesByCharacterAndBook(int $book, string $character): array
    {
        return $this->get('all/livre/' . $book . '/personnage/' . $character);
    }

    /**
     * Get random quote from the book
     *
     * @param int $book Book number
     *
     * @return array $response
     */
    public function getRandomQuoteByBook(int $book): array
    {
        return $this->get('random/livre/' . $book);
    }

    /**
     * Get random quote from the character in the book
     *
     * @param int $book Book number
     * @param string $character Character name
     *
     * @return array $response
     */
    public function getRandomQuoteByCharacterAndBook(int $book, string $character): array
    {
        return $this->get('random/livre/' . $book . '/personnage/' . $character);
    }

    /**
     * Get all books
     *
     * @return array $books
     */
    public function getBooks(): array
    {
        return [
            [1 => 'Livre I',],
            [2 => 'Livre II',],
            [3 => 'Livre III',],
            [4 => 'Livre IV',],
            [5 => 'Livre V',],
            [6 => 'Livre VI',]
        ];
    }

    /**
     * Get one book from book number
     *
     * @param int $book Book number
     *
     * @return array $name
     */
    public function getBook(int $book): array
    {
        $books = $this->getBooks();

        return $books[$book - 1];
    }

    /**
     * Get array of all characters
     *
     * @return array $characters
     */
    public function getCharacters(): array
    {
        return [
            "Angharad",
            "Anna",
            "Appius Manilius",
            "Arthur",
            "Attila",
            "Belt",
            "Père Blaise",
            "Bohort",
            "Breccan",
            "Le Roi Burgonde",
            "Caius Camillus",
            "Calogrenant",
            "Capito",
            "César",
            "Cryda de Tintagel",
            "Dagonet",
            "La Dame du Lac",
            "Demetra",
            "Drusilla",
            "Le Duc d'Aquitaine",
            "Edern",
            "Elias de Kelliwic'h",
            "Galessin",
            "Gauvain",
            "Goustan",
            "Grüdü",
            "Guenièvre",
            "Guethenoc",
            "Hervé de Rinel",
            "L'interprète burgonde",
            "Le Seigneur Jacca",
            "Les Jumelles du pêcheur",
            "Le Jurisconsulte",
            "Kadoc",
            "Karadoc",
            "Lancelot",
            "Léodagan",
            "Loth",
            "Le Maître d'Armes",
            "Méléagant",
            "Manius Macrinus Firmus",
            "Merlin",
            "Mevanwi",
            "Perceval",
            "Roparzh",
            "Lucius Sillius Sallustius",
            "Séfriane d'Aquitaine",
            "Séli",
            "Spurius Cordius Frontinius",
            "Le Tavernier",
            "Urgan",
            "Vérinus",
            "Venec",
            "Ygerne",
            "Yvain",
        ];
    }

    /**
     * Get all images from the API
     *
     * @return array $images
     */
    public function getImages(): array
    {
        $images = [];
        // Get all characters.
        foreach ($this->getCharacters() as $character) {
            // Get image.
            $response = $this->client->request('GET', 'https://kaamelott.chaudie.re/api/personnage/' . $character . '/pic');

            // If the response is an image, use it.
            $images[$character] = 'https://kaamelott.chaudie.re/api/personnage/' . $character . '/pic';

            // If the response is not an image, use a placeholder.
            if (json_decode($response->getContent(), true)) {
                $images[$character] = 'https://place-hold.it/250x250.png?text=' . $character . '&italic&fontsize=22';
            }
        }

        return $images;
    }
}
