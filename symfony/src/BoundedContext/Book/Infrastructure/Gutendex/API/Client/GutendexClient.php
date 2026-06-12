<?php

namespace App\BoundedContext\Book\Infrastructure\Gutendex\API\Client;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GutendexClient
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $gutendexBaseUrl
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function search(string $query): array
    {
        $response = $this->httpClient
            ->request(
                'GET',
                $this->gutendexBaseUrl . '/books',
                [
                    'query' => [
                        'search' => $query,
                    ],
                ]
            )
            ->toArray();

        /** @var array<string, mixed> $response */
        return $response;
    }

    /**
     * @return array<string, mixed>
     */
    public function getBook(int $id): array
    {
        $response = $this->httpClient
            ->request('GET', $this->gutendexBaseUrl . '/books/' . $id)
            ->toArray();

        /** @var array<string, mixed> $response */
        return $response;
    }
}
