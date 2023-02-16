<?php

namespace App\Controller;

use App\Service\ApiService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuoteController extends AbstractController
{
    /**
     * Display the quotes page of the website.
     *
     * @param \App\Service\ApiService $apiService
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/citations', name: 'app_quote')]
    public function index(ApiService $apiService): Response
    {
        return $this->render('quote/index.html.twig', [
            'randomQuote' => $apiService->randomQuote(),
            'quotes' => $apiService->allQuotes(),
            'images' => $apiService->getImages()
        ]);
    }
}
