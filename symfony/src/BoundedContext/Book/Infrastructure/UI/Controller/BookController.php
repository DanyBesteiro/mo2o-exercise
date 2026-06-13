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

    #[OA\Get(
        summary: 'Get book by ID',
        description: 'Returns detailed information for a single book identified by its ID.',
        tags: ['Books']
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'Unique identifier of the book',
        schema: new OA\Schema(type: 'integer', example: 1)
    )]
    #[OA\Response(
        response: 200,
        description: 'Book found',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'id', type: 'integer', example: 1),
                new OA\Property(property: 'title', type: 'string', example: '1984'),
                new OA\Property(
                    property: 'subjects',
                    type: 'array',
                    items: new OA\Items(type: 'string'),
                    example: ['dystopia', 'fiction']
                ),
                new OA\Property(
                    property: 'authors',
                    type: 'array',
                    items: new OA\Items(type: 'string'),
                    example: ['George Orwell']
                ),
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Book not found',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'error',
                    type: 'string',
                    example: 'Book not found'
                )
            ]
        )
    )]
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
