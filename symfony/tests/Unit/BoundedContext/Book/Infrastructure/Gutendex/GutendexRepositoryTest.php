<?php

namespace App\Tests\Unit\BoundedContext\Book\Infrastructure\Gutendex;

use App\BoundedContext\Book\Domain\Entity\Book;
use App\BoundedContext\Book\Infrastructure\Gutendex\API\Client\GutendexClient;
use App\BoundedContext\Book\Infrastructure\Gutendex\Repository\GutendexRepository;

use PHPUnit\Framework\TestCase;

final class GutendexRepositoryTest extends TestCase
{
    public function test_find_by_id_returns_book(): void
    {
        $client = $this->createMock(GutendexClient::class);
        $client
            ->expects($this->once())
            ->method('getBook')
            ->with(1342)
            ->willReturn([
                'id' => 1342,
                'title' => 'Pride and Prejudice',
                'subjects' => [
                    'Courtship',
                    'England'
                ],
                'authors' => [
                    [
                        'name' => 'Jane Austen',
                    ],
                ],
            ]);

        $repository = new GutendexRepository($client);

        $book = $repository->findById(1342);

        $this->assertInstanceOf(Book::class, $book);

        $this->assertSame(1342, $book->id());
        $this->assertSame('Pride and Prejudice', $book->title());

        $this->assertCount(2, $book->subjects());
        $this->assertCount(1, $book->authors());

        $this->assertSame('Jane Austen', $book->authors()[0]->name());
    }

    public function test_search_returns_books_collection(): void
    {
        $client = $this->createMock(GutendexClient::class);

        $client
            ->expects($this->once())
            ->method('search')
            ->with(['author' => 'austen'])
            ->willReturn([
                'results' => [
                    [
                        'id' => 1342,
                        'title' => 'Pride and Prejudice',
                        'subjects' => [],
                        'authors' => [
                            [
                                'name' => 'Jane Austen',
                            ],
                        ],
                    ],
                    [
                        'id' => 158,
                        'title' => 'Emma',
                        'subjects' => [],
                        'authors' => [
                            [
                                'name' => 'Jane Austen',
                            ],
                        ],
                    ],
                ],
            ]);

        $repository = new GutendexRepository($client);

        $books = $repository->search(['author' => 'austen']);

        $this->assertCount(2, $books);

        $this->assertContainsOnlyInstancesOf(Book::class, $books);
        $this->assertSame('Pride and Prejudice', $books[0]->title());
        $this->assertSame('Emma', $books[1]->title());
    }
}
