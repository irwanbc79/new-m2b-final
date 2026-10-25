<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\B2bInquiry;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicInquirySecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        Storage::fake('local');
        Storage::fake('public');
    }

    private function payload(): array
    {
        return ['name' => 'Test', 'company' => 'Test Company', 'npwp' => '123',
            'email' => 'test@example.com', 'phone' => '08123456789',
            'service_type' => 'paid', 'cargo_direction' => 'impor'];
    }

    public function test_disallowed_and_disguised_files_are_rejected(): void
    {
        foreach (['invoice_file', 'packing_list_file', 'catalog_file'] as $field) {
            foreach (['payload.html', 'payload.pdf'] as $name) {
                $file = UploadedFile::fake()->createWithContent($name, '<html><script>alert(1)</script></html>');
                $file->mimeType('text/html');
                $this->postJson('/b2b/inquiry', $this->payload() + [$field => $file])
                    ->assertUnprocessable()->assertJsonValidationErrors($field);
            }
        }
        $this->assertDatabaseCount('b2b_inquiries', 0);
        $this->assertSame([], Storage::disk('local')->allFiles());
    }

    public function test_documents_always_use_private_disk(): void
    {
        config(['filesystems.default' => 'public']);
        $file = UploadedFile::fake()->createWithContent('invoice.pdf', "%PDF-1.4\n1 0 obj\n<<>>\nendobj\n%%EOF");
        $this->postJson('/b2b/inquiry', $this->payload() + ['invoice_file' => $file])
            ->assertOk()->assertJsonPath('success', true);
        $inquiry = B2bInquiry::firstOrFail();
        Storage::disk('local')->assertExists($inquiry->files[0]['path']);
        $this->assertSame('application/pdf', $inquiry->files[0]['mime_type']);
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_failed_upload_does_not_create_successful_inquiry(): void
    {
        $disk = \Mockery::mock(\Illuminate\Contracts\Filesystem\Filesystem::class);
        $disk->shouldReceive('putFileAs')->once()->andReturn(false);
        Storage::shouldReceive('disk')->with('local')->andReturn($disk);
        $file = UploadedFile::fake()->createWithContent('invoice.pdf', "%PDF-1.4\n%%EOF");
        $this->postJson('/b2b/inquiry', $this->payload() + ['invoice_file' => $file])->assertStatus(503);
        $this->assertDatabaseCount('b2b_inquiries', 0);
    }

    public function test_database_failure_cleans_up_uploaded_document(): void
    {
        \Illuminate\Support\Facades\Schema::drop('b2b_inquiries');
        $file = UploadedFile::fake()->createWithContent('invoice.pdf', "%PDF-1.4\n%%EOF");
        $this->postJson('/b2b/inquiry', $this->payload() + ['invoice_file' => $file])->assertStatus(500);
        $this->assertSame([], Storage::disk('local')->allFiles());
    }
}
