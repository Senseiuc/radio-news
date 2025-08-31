<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiCategoriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_categories_index_returns_categories(): void
    {
        Category::factory()->count(3)->create();

        $res = $this->getJson('/api/categories');
        $res->assertOk()->assertJsonStructure(['data' => [['name','slug','color']]]);
    }
}
