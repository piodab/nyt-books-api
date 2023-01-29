<?php

declare(strict_types=1);

namespace App\Services\NewYorkTimes;

use Illuminate\Support\Facades\Http;

class BestSellersService
{
    public function search(array $searchData)
    {
        $url = config('new-york-times.base_url') . config('new-york-times.books_api_endpoint');
        $searchData['api-key'] = config('new-york-times.api_key');

        $response = Http::get($url, $searchData);

        return $response->json()['results'];
    }
}
