<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Post;
use Illuminate\Http\Response;
use Tests\TestCase;

class PostTest extends TestCase
{

    use RefreshDatabase;

    public function test_can_register_post(): void
    {

        $post = Post::factory()->create();

        $response = $this->post('/api/post', [
            'title' => $post->title,
            'body' => $post->body,
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }
}
