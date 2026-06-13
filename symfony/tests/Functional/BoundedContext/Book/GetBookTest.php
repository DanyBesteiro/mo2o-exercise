<?php

declare(strict_types=1);

namespace App\Tests\Functional\BoundedContext\Book;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\BoundedContext\Book\Infrastructure\Gutendex\API\Client\GutendexClient;

final class GetBookTest extends WebTestCase
{
    public function test_get_book_by_id_returns_expected_response(): void
    {
        $client = static::createClient();

        $clientMock = $this->createMock(GutendexClient::class);

        $clientMock->expects($this->once())
            ->method('getBook')
            ->with(5)
            ->willReturn([
                'id' => 5,
                'title' => 'The United States Constitution',
                'subjects' => [
                    'US Politics'
                ],
                'authors' => [
                    ['name' => 'United States']
                ]
            ]);

        self::getContainer()->set(GutendexClient::class, $clientMock);

        $client->request('GET', '/books/5');

        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(5, $data['id']);
        $this->assertEquals('The United States Constitution', $data['title']);
        $this->assertEquals(['US Politics'], $data['subjects']);
        $this->assertEquals(['United States'], $data['authors']);
    }
}
