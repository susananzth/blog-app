<?php

namespace Tests\Feature;

use App\Models\Tag;
use Illuminate\Http\Response;
use Laravel\Passport\Passport;
use Tests\PassportAdminTestCase;

class TagTest extends PassportAdminTestCase
{
    public function test_can_list_tags(): void
    {
        $tag = Tag::factory(5)->create();

        $response = $this->get('/api/tag');

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_store_tag() : void
    {
        $response = $this->post('/api/tag', [
            'name' => fake()->realTextBetween($minNbChars = 10, $maxNbChars = 25, $indexSize = 1),
        ]);

        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_edit_tag(): void
    {
        $tag = Tag::factory()->create();

        $response = $this->get(route('tag.edit', $tag->id));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_update_tag(): void
    {
        $tag = Tag::factory()->create();

        $response = $this->put(route('tag.update', $tag->id), [
            'name' => fake()->realTextBetween($minNbChars = 10, $maxNbChars = 25, $indexSize = 1),
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_show_tag(): void
    {
        $tag = Tag::factory()->create();

        $response = $this->get(route('tag.show', $tag->id));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_delete_tag(): void
    {
        $tag = Tag::factory()->create();

        $response = $this->delete(route('tag.destroy', $tag->id));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }
}
