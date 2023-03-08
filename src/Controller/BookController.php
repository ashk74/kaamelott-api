<?php

namespace App\Controller;

use App\Service\ApiService;
use App\Service\CacheService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    /**
     * BookController constructor
     *
     * @param \App\Service\ApiService $apiService Used to get data from the API
     * @param \App\Service\CacheService $cacheService Used to get data from the cache
     */
    public function __construct(private ApiService $apiService, private CacheService $cacheService)
    {
    }

    /**
     * Display the books page of the website.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/livres', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'randomQuote' => $this->apiService->randomQuote(),
            'books' => $this->cacheService->get('books', $this->apiService->getBooks())
        ]);
    }

    /**
     * Display the list of quotes from a book
     *
     * @param int $id Book ID
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/livre/{id}', name: 'app_book_show')]
    public function show(int $id): Response
    {
        if ($id < 1 || $id > 6) {
            return $this->redirectToRoute('app_book');
        }

        return $this->render('book/show.html.twig', [
            'randomQuote' => $this->apiService->randomQuote(),
            'quotesByBook' => $this->cacheService->get('quotesByBook_' . $id, $this->apiService->getQuotesByBook($id)),
            'book' => $this->cacheService->get('book_' . $id, $this->apiService->getBook($id)),
            'images' => $this->cacheService->get('images', $this->apiService->getImages())
        ]);
    }
}
