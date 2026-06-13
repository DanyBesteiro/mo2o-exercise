<?php

declare(strict_types=1);

namespace App\BoundedContext\Book\Application\UseCase;

use App\BoundedContext\Book\Domain\Entity\Book;
use App\BoundedContext\Book\Domain\Repository\BookRepositoryInterface;

final class SearchBooks
{
    public function __construct(
        private BookRepositoryInterface $repository
    ) {}

    /**
     * @return Book[]
     */
    public function execute(array $filters): array
    {
        if (empty($filters)) {
            return [];
        }

        return $this->repository->search($filters);
    }
}
