<?php

declare(strict_types=1);

namespace App\Book\Domain\Entity;

final class Author
{
    public function __construct(
        private readonly string $name
    ) {}

    public function name(): string
    {
        return $this->name;
    }
}
