<?php

declare(strict_types=1);

namespace App\BoundedContext\Book\Infrastructure\UI\Controller;

use App\BoundedContext\Book\Application\UseCase\GetBookById;
use App\BoundedContext\Book\Application\UseCase\SearchBooks;
use App\BoundedContext\Book\Application\DTO\BookResponseDTO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BookController extends AbstractController
{
    public function __construct(
        private readonly GetBookById $getBookById,
        private readonly SearchBooks $searchBooks
    ) {}

    public function getBook(int $id): JsonResponse
    {
        $book = $this->getBookById->execute($id);

        if (is_null($book)) {
            return $this->json(['error' => 'Book not found'], 404);
        }

        return $this->json(
            BookResponseDTO::fromBook($book)->toArray()
        );
    }

    public function search(Request $request): JsonResponse
    {
        $filters = $request->query->all();

        $books = $this->searchBooks->execute($filters);

        if (is_null($books)) {
            return $this->json(['error' => 'Books not found'], 404);
        }

        return $this->json(
            array_map(
                fn($book) => BookResponseDTO::fromBook($book)->toArray(),
                $books
            )
        );
    }
}
