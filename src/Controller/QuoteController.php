<?php

namespace App\Controller;

use App\Service\ApiService;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuoteController extends AbstractController
{
    /**
     * QuoteController constructor
     *
     * @param \App\Service\ApiService $apiService Used to get data from the API
     * @param \App\Service\CacheService $cacheService Used to get data from the cache
     */
    public function __construct(private ApiService $apiService, private CacheService $cacheService)
    {
    }

    /**
     * Display the quotes page of the website.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/citations', name: 'app_quote')]
    public function index(): Response
    {
        return $this->render('quote/index.html.twig', [
            'randomQuote' => $this->apiService->randomQuote(),
            'quotes' => $this->cacheService->get('quotes', $this->apiService->allQuotes()),
            'images' => $this->cacheService->get('images', $this->apiService->getImages())
        ]);
    }
}
