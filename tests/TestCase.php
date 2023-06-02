<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected array $headerRequest;
    private string $jwt = "1";

    protected function setUp(): void
    {
        parent::setUp();

        $this->headerRequest = [
            'Accept' => 'application/json',
            'Accept-Language' => 'fa',
            'Authorization' => $this->jwt
        ];
    }

    protected function setUser(int $userId)
    {
        $this->jwt = $userId;
    }
}
