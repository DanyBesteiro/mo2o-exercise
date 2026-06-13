<?php

declare(strict_types=1);

namespace App\BoundedContext\Book\Infrastructure\UI\Controller;

use Symfony\Component\HttpFoundation\Request;

final class SearchBooksRequest
{
    public function __construct() {}

    public static function fromRequest(Request $request): string
    {
        $filters = $request->query->all();

        if (empty($filters)) {
            return '';
        }

        $out = '?';

        foreach ($filters as $key => $value) {
            $out .= $key . '=' . $value . '&';
        }

        return trim($out, '&');
    }
}
