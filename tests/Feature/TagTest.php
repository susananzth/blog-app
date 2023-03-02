<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\Post;
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

    public function test_can_not_store_tag_with_invalid_name() : void
    {
        $response = $this->post('/api/tag', [
            'name' => fake()->realTextBetween($minNbChars = 100, $maxNbChars = 250, $indexSize = 1),
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_not_store_tag_with_repeat_name() : void
    {
        $tag = Tag::factory()->create();

        $response = $this->post('/api/tag', [
            'name' => $tag->name,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

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

    public function test_can_not_edit_tag_with_wrong_id(): void
    {
        $response = $this->get(route('tag.edit', 0));

        $response->assertStatus(Response::HTTP_NOT_FOUND);

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

    public function test_can_not_update_tag_with_invalid_name(): void
    {
        $tag = Tag::factory()->create();

        $response = $this->put(route('tag.update', $tag->id), [
            'name' => fake()->realTextBetween($minNbChars = 100, $maxNbChars = 250, $indexSize = 1),
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_not_update_tag_with_repeat_name(): void
    {
        $tag = Tag::factory()->create();

        $tag_2 = Tag::factory()->create();

        $response = $this->put(route('tag.update', $tag->id), [
            'name' => $tag_2->name,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

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

    public function test_can_not_show_tag_with_wrong_id(): void
    {
        $response = $this->get(route('tag.show', 0));

        $response->assertStatus(Response::HTTP_NOT_FOUND);

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

    public function test_can_not_delete_tag_with_posts(): void
    {
        $tag = Tag::factory()->has(Post::factory()->count(3))->create();

        $response = $this->delete(route('tag.destroy', $tag->id));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }
}
