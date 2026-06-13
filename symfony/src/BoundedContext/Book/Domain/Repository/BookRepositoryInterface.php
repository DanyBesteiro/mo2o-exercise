<?php

declare(strict_types=1);

namespace App\BoundedContext\Book\Domain\Repository;

use App\BoundedContext\Book\Domain\Entity\Book;

interface BookRepositoryInterface
{
    /**
     * @param array<string, mixed> $filters
     * @return Book[]
     */
    public function search(array $filters): array;

    public function findById(int $id): ?Book;
}
