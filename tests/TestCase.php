<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.connections.portal' => config('database.connections.sqlite')]);
        \Illuminate\Support\Facades\Http::fake();
        \Illuminate\Support\Facades\Http::preventStrayRequests();
    }
}
