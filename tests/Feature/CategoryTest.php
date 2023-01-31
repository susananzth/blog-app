<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_categories(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['BlogApp']
        );

        $category = Category::factory(5)->create();

        $response = $this->get('/api/category');

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_create_category() : void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['BlogApp']
        );

        $category = Category::factory()->create();

        $response = $this->post('/api/category', [
            'name' => $category->name,
        ]);

        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_update_category(): void
    {

        Sanctum::actingAs(
            User::factory()->create(),
            ['BlogApp']
        );

        $category = Category::factory()->create();

        $response = $this->put(route('category.update', $category->id), [
            'name' => $category->name,
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_show_category(): void
    {

        Sanctum::actingAs(
            User::factory()->create(),
            ['BlogApp']
        );

        $category = Category::factory()->create();

        $response = $this->get(route('category.show', $category->id));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_delete_category(): void
    {

        Sanctum::actingAs(
            User::factory()->create(), 
            ['BlogApp']
        );

        $category = Category::factory()->create();

        $response = $this->delete(route('category.destroy', $category->id));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }
}
