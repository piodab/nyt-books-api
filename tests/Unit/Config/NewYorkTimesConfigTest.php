<?php

declare(strict_types=1);

namespace Config;

use Tests\TestCase;

class NewYorkTimesConfigTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_config_key_exist(): void
    {
        // Arrange
        $newYorkTimesConfig = config('new-york-times');

        // Assert
        $this->assertArrayHasKey('base_url', $newYorkTimesConfig);
        $this->assertArrayHasKey('books_api_endpoint', $newYorkTimesConfig);
        $this->assertArrayHasKey('api_key', $newYorkTimesConfig);
    }
}
