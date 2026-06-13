<?php

declare(strict_types=1);

namespace App\BoundedContext\Book\Infrastructure\UI\Controller;

use App\BoundedContext\Book\Application\UseCase\GetBookById;
use App\BoundedContext\Book\Application\UseCase\SearchBooks;
use App\BoundedContext\Book\Application\DTO\BookResponseDTO;

use OpenApi\Attributes as OA;

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

    #[OA\Get(
        summary: 'Search books',
        description: 'Returns a list of books with optional filters and pagination',
        tags: ['Books']
    )]
    #[OA\Parameter(name: 'title', in: 'query', schema: new OA\Schema(type: 'string'))]
    #[OA\Parameter(name: 'author', in: 'query', schema: new OA\Schema(type: 'string'))]
    #[OA\Parameter(name: 'language', in: 'query', schema: new OA\Schema(type: 'string'))]
    #[OA\Response(
        response: 200,
        description: 'List of books',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                type: 'object',
                properties: [
                    new OA\Property(property: 'id', type: 'integer'),
                    new OA\Property(property: 'title', type: 'string'),
                    new OA\Property(property: 'subjects', type: 'array', items: new OA\Items(type: 'string')),
                    new OA\Property(property: 'authors', type: 'array', items: new OA\Items(type: 'string')),
                ]
            )
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Books not found',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'error', type: 'string', example: 'Books not found')
            ]
        )
    )]
    public function search(Request $request): JsonResponse
    {
        $filters = $request->query->all();

        $books = $this->searchBooks->execute($filters);

        if (empty($books)) {
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
