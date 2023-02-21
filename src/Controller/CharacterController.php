<?php

namespace App\Controller;

use App\Service\ApiService;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CharacterController extends AbstractController
{
    /**
     * CharacterController constructor
     *
     * @param \App\Service\ApiService $apiService Used to get data from the API
     * @param \App\Service\CacheService $cacheService Used to get data from the cache
     */
    public function __construct(private ApiService $apiService, private CacheService $cacheService)
    {
    }

    /**
     * Display the characters page of the website.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/personnages', name: 'app_character')]
    public function index(): Response
    {
        return $this->render('character/index.html.twig', [
            'randomQuote' => $this->apiService->randomQuote(),
            'characters' => $this->cacheService->get('characters', $this->apiService->getCharacters()),
            'images' => $this->cacheService->get('images', $this->apiService->getImages())
        ]);
    }

    /**
     * Display the list of quotes from a character
     *
     * @param string $name Character name
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/personnage/{name}', name: 'app_character_show'),]
    public function show(string $name): Response
    {
        if (!in_array($name, $this->apiService->getCharacters())) {
            return $this->redirectToRoute('app_character');
        }

        return $this->render('character/show.html.twig', [
            'randomQuote' => $this->apiService->randomQuote(),
            'character' => $name,
            'characterQuotes' => $this->cacheService->get('characterQuotes_' . $name, $this->apiService->getQuotesByCharacter($name))
        ]);
    }
}
