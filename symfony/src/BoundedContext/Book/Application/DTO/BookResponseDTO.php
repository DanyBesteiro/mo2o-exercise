<?php

declare(strict_types=1);

namespace App\BoundedContext\Book\Application\DTO;

use App\BoundedContext\Book\Domain\Entity\Book;

final class BookResponseDTO
{
    /**
     * @param string[] $subjects
     * @param string[] $authors
     */
    public function __construct(
        public int $id,
        public string $title,
        public array $subjects,
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
