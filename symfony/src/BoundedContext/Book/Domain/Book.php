<?php

declare(strict_types=1);

namespace App\Book\Domain\Entity;

final class Book
{
    /**
     * @param Author[] $authors
     * @param string[] $subjects
     */
    public function __construct(
        private readonly int $id,
        private readonly string $title,
        private readonly array $subjects,
        private readonly array $authors
    ) {}

    public function id(): int
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return string[]
     */
    public function subjects(): array
    {
        return $this->subjects;
    }

    /**
     * @return Author[]
     */
    public function authors(): array
    {
        return $this->authors;
    }
}
