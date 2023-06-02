<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected array $headerRequest;

    protected function setUp(): void
    {
        parent::setUp();

        $this->headerRequest = [
            'Accept' => 'application/json',
            'Accept-Language' => 'fa',
            'Authorization' => "1"
        ];
    }

    protected function setUser(int $userId)
    {
        $this->headerRequest["Authorization"] = $userId;
    }
}
