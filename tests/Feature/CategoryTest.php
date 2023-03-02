<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Http\Response;
use Laravel\Passport\Passport;
use Tests\PassportAdminTestCase;

class CategoryTest extends PassportAdminTestCase
{
    public function test_can_list_categories(): void
    {
        $category = Category::factory(5)->create();

        $response = $this->get('/api/category');

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_store_category() : void
    {
        $response = $this->post('/api/category', [
            'name' => fake()->realTextBetween($minNbChars = 10, $maxNbChars = 25, $indexSize = 1),
        ]);

        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_edit_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->get(route('category.edit', $category->id));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_update_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->put(route('category.update', $category->id), [
            'name' => fake()->realTextBetween($minNbChars = 10, $maxNbChars = 25, $indexSize = 1),
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
