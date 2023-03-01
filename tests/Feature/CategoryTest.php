<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Response;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_categories(): void
    {
        $user = User::factory()->create();
        $user->roles()->sync(2);
        Passport::actingAs($user, ['BlogApp']);

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
        $user = User::factory()->create();
        $user->roles()->sync(2);
        Passport::actingAs($user, ['BlogApp']);

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
        $user = User::factory()->create();
        $user->roles()->sync(2);
        Passport::actingAs($user, ['BlogApp']);

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
        $user = User::factory()->create();
        $user->roles()->sync(2);
        Passport::actingAs($user, ['BlogApp']);

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
        $user = User::factory()->create();
        $user->roles()->sync(2);
        Passport::actingAs($user, ['BlogApp']);

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
        $user = User::factory()->create();
        $user->roles()->sync(2);
        Passport::actingAs($user, ['BlogApp']);

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
