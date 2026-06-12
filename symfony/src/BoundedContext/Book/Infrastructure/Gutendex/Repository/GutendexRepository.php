<?php

declare(strict_types=1);

namespace App\BoundedContext\Book\Infrastructure\Gutendex\Repository;

use App\BoundedContext\Book\Domain\Entity\Book;
use App\BoundedContext\Book\Domain\Entity\Author;

use App\BoundedContext\Book\Infrastructure\Gutendex\API\Client\GutendexClient;
use App\BoundedContext\Book\Domain\Repository\BookRepositoryInterface;

final class GutendexRepository implements BookRepositoryInterface
{
    public function __construct(private GutendexClient $client) {}

    public function search(string $query): array
    {
        $response = $this->client->search($query);

        return array_map(
            fn(array $book) => new Book(
                $book['id'],
                $book['title'],
                $book['subjects'],
                array_map(
                    fn(array $author) => new Author($author['name']),
                    $book['authors']
                )
            ),
            $response['results']
        );
    }

    public function findById(int $id): ?Book
    {
        $response = $this->client->getBook($id);

        if (empty($response)) {
            return null;
        }

        return new Book(
            $response['id'],
            $response['title'],
            $response['subjects'],
            array_map(
                fn(array $author) => new Author($author['name']),
                $response['authors']
            )
        );
    }
}
