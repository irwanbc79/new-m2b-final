<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class AdSenseBlockTest extends TestCase
{
    public function test_it_renders_a_configured_production_slot(): void
    {
        config()->set('app.env', 'production');
        config()->set('services.adsense.publisher_id', 'ca-pub-5616961797801657');
        config()->set('services.adsense.slot_in_content', '8299147673');

        $html = Blade::render('<x-adsense-block type="in_content" />');

        $this->assertStringContainsString('data-ad-slot="8299147673"', $html);
        $this->assertStringNotContainsString('0000000000', $html);
    }

    public function test_it_suppresses_the_placeholder_slot_in_production(): void
    {
        config()->set('app.env', 'production');
        config()->set('services.adsense.publisher_id', 'ca-pub-5616961797801657');
        config()->set('services.adsense.slot_in_content', '0000000000');

        $html = Blade::render('<x-adsense-block type="in_content" />');

        $this->assertStringNotContainsString('adsbygoogle', $html);
        $this->assertStringNotContainsString('data-ad-slot', $html);
    }
}
