<?php

declare(strict_types=1);

namespace App\BoundedContext\Book\Domain\Repository;

use App\BoundedContext\Book\Domain\Entity\Book;

interface BookRepositoryInterface
{
    /**
     * @return Book[]
     */
    public function search(string $query): array;

    public function findById(int $id): ?Book;
}
