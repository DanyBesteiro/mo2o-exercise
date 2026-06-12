<?php

namespace App\BoundedContext\Book\Infrastructure\Gutendex\API\Client;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GutendexClient
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $gutendexBaseUrl
    ) {}

    public function search(string $query): array
    {
        return $this->httpClient
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
    }

    /**
     * @return array{
     *     id:int,
     *     title:string,
     *     subjects:string[],
     *     authors:array<int,array{name:string}>
     * }
     */
    public function getBook(int $id): array
    {
        return $this->httpClient
            ->request('GET', $this->gutendexBaseUrl . '/books/' . $id)
            ->toArray();
    }
}
