<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Http\Response;
use Tests\PassportAdminTestCase;

class PostTest extends PassportAdminTestCase
{
    public function test_can_list_posts(): void
    {
        $post = Post::factory(5)->create();

        $response = $this->get(route('post.index'));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_create_post(): void
    {
        $category = Category::factory(2)->create();
        $tag      = Tag::factory(2)->create();

        $response = $this->get(route('post.create'));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_store_post() : void
    {
        $category = Category::factory()->create();
        $tag      = Tag::factory()->create();

        $response = $this->post(route('post.store'), [
            'title' => fake()->text(150),
            'body' => fake()->paragraph(),
            'status' => 1,
            'category' => [
                $category->id
            ],
            'tag' => [
                $tag->id
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
        $post = Post::factory()->create();

        $category = Category::factory(2)->create();
        $tag      = Tag::factory(2)->create();

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
        $post = Post::factory()->create();

        $category = Category::factory()->create();
        $tag      = Tag::factory()->create();

        $response = $this->put(route('post.update', $post->id), [
            'title' => fake()->text(150),
            'body' => fake()->paragraph(),
            'status' => 1,
            'category' => [
                $category->id
            ],
            'tag' => [
                $tag->id
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
