<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class PostTest extends TestCase
{

    use RefreshDatabase;

    public function test_can_list_posts(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['BlogApp']
        );

        $post = Post::factory(5)->create();

        $response = $this->get('/api/post');

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_create_post(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['BlogApp']
        );

        $category = Category::factory(2)->create();

        $response = $this->get('/api/post/create');

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_store_post() : void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['BlogApp']
        );

        $post = Post::factory()->create();
        $category = Category::factory()->create();

        $response = $this->post('/api/post', [
            'title' => $post->title,
            'body' => $post->body,
            'category' => [
                $category->id
            ]
        ]);

        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }
    
    public function test_can_edit_post(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['BlogApp']
        );

        $post = Post::factory()->create();
        $category = Category::factory(2)->create();

        $response = $this->get(route('post.edit', $post->id));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_update_post(): void
    {

        Sanctum::actingAs(
            User::factory()->create(),
            ['BlogApp']
        );

        $post = Post::factory()->create();
        $category = Category::factory()->create();

        $response = $this->put(route('post.update', $post->id), [
            'title' => $post->title,
            'body' => $post->body,
            'category' => [
                $category->id
            ]
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_show_post(): void
    {

        Sanctum::actingAs(
            User::factory()->create(),
            ['BlogApp']
        );

        $post = Post::factory()->create();

        $response = $this->get(route('post.show', $post->id));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_delete_post(): void
    {

        Sanctum::actingAs(
            User::factory()->create(), 
            ['BlogApp']
        );

        $post = Post::factory()->create();

        $response = $this->delete(route('post.destroy', $post->id));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }
}
