<?php

namespace App\Controller;

use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    /**
     * Display the characters page of the website.
     *
     * @param \App\Service\ApiService $apiService
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/personnages', name: 'app_character')]
    public function index(ApiService $apiService): Response
    {
        return $this->render('character/index.html.twig', [
            'randomQuote' => $apiService->randomQuote(),
            'characters' => $apiService->getCharacters(),
            'images' => $apiService->getImages()
        ]);
    }

    /**
     * Display quotes of a character.
     *
     * @param \App\Service\ApiService $apiService
     * @param string $name Character name
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/personnage/{name}', name: 'app_character_show'),]
    public function show(ApiService $apiService, string $name): Response
    {
        if (!in_array($name, $apiService->getCharacters())) {
            return $this->redirectToRoute('app_character');
        }

        return $this->render('character/show.html.twig', [
            'randomQuote' => $apiService->randomQuote(),
            'character' => $name,
            'characterQuotes' => $apiService->getQuotesByCharacter($name),
        ]);
    }
}
