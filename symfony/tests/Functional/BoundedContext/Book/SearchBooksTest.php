<?php

declare(strict_types=1);

namespace App\Tests\Functional\BoundedContext\Book;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\BoundedContext\Book\Infrastructure\Gutendex\API\Client\GutendexClient;

final class SearchBooksTest extends WebTestCase
{
    public function test_search_books_returns_expected_response(): void
    {
        $client = static::createClient();
        $clientMock = $this->createMock(GutendexClient::class);

        $clientMock
            ->expects($this->once())
            ->method('search')
            ->willReturn([
                'results' => [
                    [
                        'id' => 1,
                        'title' => 'Clean Code',
                        'subjects' => ['Software'],
                        'authors' => [
                            ['name' => 'Robert C. Martin']
                        ]
                    ]
                ]
            ]);

        self::getContainer()->set(GutendexClient::class, $clientMock);

        $client->request('GET', '/books?author=martin');

        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertCount(1, $data);
        $this->assertEquals('Clean Code', $data[0]['title']);
        $this->assertEquals(1, $data[0]['id']);
    }
}
