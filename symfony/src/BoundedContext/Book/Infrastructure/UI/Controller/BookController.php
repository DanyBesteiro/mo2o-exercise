<?php

declare(strict_types=1);

namespace App\BoundedContext\Book\Infrastructure\UI\Controller;

use App\BoundedContext\Book\Application\UseCase\GetBookById;
use App\BoundedContext\Book\Application\DTO\BookResponseDTO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BookController extends AbstractController
{
    public function __construct(
        private readonly GetBookById $getBookById
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
}
