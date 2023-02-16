<?php

namespace App\Controller;

use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * Display the list of books
     *
     * @param \App\Service\ApiService $apiService
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/livres', name: 'app_book')]
    public function index(ApiService $apiService): Response
    {
        return $this->render('book/index.html.twig', [
            'randomQuote' => $apiService->randomQuote(),
            'books' => $apiService->getBooks()
        ]);
    }

    /**
     * Display quotes of a book.
     *
     * @param \App\Service\ApiService $apiService
     * @param int $id Book id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/livre/{id}', name: 'app_book_show')]
    public function show(ApiService $apiService, int $id): Response
    {
        if ($id < 1 || $id > 6) {
            return $this->redirectToRoute('app_book');
        }

        return $this->render('book/show.html.twig', [
            'randomQuote' => $apiService->randomQuote(),
            'quotesByBook' => $apiService->getQuotesByBook($id),
            'book' => $apiService->getBook($id)
        ]);
    }
}
