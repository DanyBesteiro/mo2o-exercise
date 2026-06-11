<?php

declare(strict_types=1);

namespace App\Tests\BoundedContext\Book\Domain\Entity;

use App\BoundedContext\Book\Domain\Entity\Author;
use App\BoundedContext\Book\Domain\Entity\Book;
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{
    public function test_can_create_book_with_valid_data(): void
    {
        $authors = [
            new Author('Jane Austen')
        ];

        $subjects = ['Romance', 'Classic'];

        $book = new Book(
            'Pride and Prejudice',
            $subjects,
            $authors
        );

        $this->assertNotEmpty($book->id());
        $this->assertTrue(\Symfony\Component\Uid\Uuid::isValid($book->id()->toRfc4122()));
        $this->assertSame('Pride and Prejudice', $book->title());
        $this->assertSame($subjects, $book->subjects());

        $this->assertCount(1, $book->authors());
        $this->assertSame('Jane Austen', $book->authors()[0]->name());
    }

    public function test_cannot_create_book_with_invalid_data(): void
    {
        $this->expectException(\TypeError::class);

        new Book(
            null,
            [],
            []
        );
    }
}
