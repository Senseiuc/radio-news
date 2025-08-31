<?php

namespace Tests\Feature;

use App\Services\DailyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class CallJoinPageTest extends TestCase
{
    use RefreshDatabase;

    protected function mockDaily(): void
    {
        $mock = Mockery::mock(DailyService::class);
        $mock->shouldReceive('createRoom')->andReturn(['name' => 'homeland-public']);
        $mock->shouldReceive('createMeetingToken')->andReturn(['token' => 'abc123']);
        $this->app->instance(DailyService::class, $mock);
    }

    public function test_guest_can_access_join_call_and_embed_url_contains_prebuilt(): void
    {
        $this->mockDaily();

        $res = $this->get(route('call.join'));
        $res->assertOk();
        $res->assertViewIs('calls.join');
        $res->assertViewHas('embedUrl', function ($url) {
            return str_contains($url, 'embedType=prebuilt');
        });
    }
}
