<?php

namespace App\BoundedContext\Book\Application\UseCase;

use App\BoundedContext\Book\Domain\Entity\Book;
use App\BoundedContext\Book\Domain\Repository\BookRepositoryInterface;

final class GetBookById
{
    public function __construct(
        private BookRepositoryInterface $repository
    ) {}

    public function execute(int $id): ?Book
    {
        return $this->repository->findById($id);
    }
}
