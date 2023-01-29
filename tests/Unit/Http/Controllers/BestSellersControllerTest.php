<?php

declare(strict_types=1);

namespace Http\Controllers;

use App\Services\NewYorkTimes\BestSellersService;
use Mockery;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class BestSellersControllerTest extends TestCase
{
    public function test_endpoint_should_contain_at_least_one_parameter (): void
    {
        // Act
        $response = $this->json('GET',  route('api.v1.nyt.best_sellers'));

        // Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_offset_should_be_a_multiple_of_twenty_or_zero (): void
    {
        //Arrange
        $data = ['offset' => 21];

        // Act
        $response = $this->json('GET',  route('api.v1.nyt.best_sellers', $data));

        // Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_one_isbn_should_contain_10_or_13_digits (): void
    {
        //Arrange
        $data = ['isbn' => 123456789];

        // Act
        $response = $this->json('GET',  route('api.v1.nyt.best_sellers', $data));

        // Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_multiple_isbn_should_contain_10_or_13_digits (): void
    {
        //Arrange
        $data = ['isbn' => [
            123456789,
            123456788
        ]];

        // Act
        $response = $this->json('GET',  route('api.v1.nyt.best_sellers', $data));

        // Assert
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_endpoint_best_sellers (): void
    {
        //Arrange
        $mock = Mockery::mock(BestSellersService::class);
        $mock->shouldReceive('search')
            ->once()
            ->andReturn([]);

        $this->app->instance(BestSellersService::class, $mock);
        $data = [
            'isbn' => [
                9780606351461,
                9781444727326
            ],
            'author' => 'Stephen King',
            'offset' => 20,
            'title' => 'Nightmares and Dreamscapes'
        ];

        // Act
        $response = $this->json('GET',  route('api.v1.nyt.best_sellers', $data));

        // Assert
        $response->assertStatus(Response::HTTP_OK);
    }
}
