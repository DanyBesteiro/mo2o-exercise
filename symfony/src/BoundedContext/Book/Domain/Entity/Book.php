<?php

declare(strict_types=1);

namespace App\BoundedContext\Book\Domain\Entity;

use Symfony\Component\Uid\Uuid;


final class Book
{
    private Uuid $id;

    /**
     * @param Author[] $authors
     * @param string[] $subjects
     */
    public function __construct(
        private readonly string $title,
        private readonly array $subjects,
        private readonly array $authors
    ) {
        $this->id = Uuid::v4();
    }

    public function id(): Uuid
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
