<?php

namespace Tests\Feature;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class MoraResilienceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Http::swap(new \Illuminate\Http\Client\Factory);
        Http::preventStrayRequests();
    }

    public function test_connection_failure_tries_next_provider(): void
    {
        config(['services.mora.openai_key' => 'test-only']);
        Http::fake(function ($request) {
            if (str_contains($request->url(), 'api.openai.com')) {
                throw new ConnectionException('Test timeout');
            }
            return Http::response(['candidates' => [['content' => ['parts' => [['text' => 'Fallback reply']]]]]]);
        });
        $this->postJson('/mora/chat', ['history' => [['role' => 'user', 'content' => 'Halo']]])
            ->assertOk()->assertJsonPath('reply', 'Fallback reply');
    }

    public function test_all_connection_failures_return_controlled_unavailable_response(): void
    {
        config(['services.mora.openai_key' => 'test-only', 'services.mora.deepseek_key' => 'test-only']);
        Http::fake(fn () => throw new ConnectionException('Test timeout'));
        $this->postJson('/mora/chat', ['history' => [['role' => 'user', 'content' => 'Halo']]])
            ->assertStatus(503)->assertJsonStructure(['error']);
    }

    public function test_oversized_image_is_rejected_before_provider_call(): void
    {
        $this->postJson('/mora/chat', [
            'history' => [['role' => 'user', 'content' => 'Halo']],
            'image' => ['mimeType' => 'image/png', 'data' => str_repeat('a', 6990509)],
        ])->assertUnprocessable()->assertJsonValidationErrors('image.data');
        Http::assertNothingSent();
    }
}
