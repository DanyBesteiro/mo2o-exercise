<?php

declare(strict_types=1);

namespace App\BoundedContext\Book\Application\DTO;

use App\BoundedContext\Book\Domain\Entity\Book;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Book',
    type: 'object'
)]
final class BookResponseDTO
{
    /**
     * @param string[] $subjects
     * @param string[] $authors
     */
    public function __construct(
        #[OA\Property(example: 1)]
        public int $id,

        #[OA\Property(example: '1984')]
        public string $title,

        #[OA\Property(
            type: 'array',
            items: new OA\Items(type: 'string'),
            example: ['fiction', 'dystopia']
        )]
        public array $subjects,

        #[OA\Property(
            type: 'array',
            items: new OA\Items(type: 'string'),
            example: ['George Orwell']
        )]
        public array $authors,
    ) {}

    /**
     * @return array{
     *     id:int,
     *     title:string,
     *     subjects:string[],
     *     authors:string[]
     * }
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'subjects' => $this->subjects,
            'authors' => $this->authors,
        ];
    }

    public static function fromBook(Book $book): self
    {
        return new self(
            id: $book->id(),
            title: $book->title(),
            subjects: $book->subjects(),
            authors: array_map(
                static fn($author): string => $author->name(),
                $book->authors()
            )
        );
    }
}
