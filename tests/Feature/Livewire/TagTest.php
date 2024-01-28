<?php

namespace Tests\Feature\Livewire;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Http\Livewire\Tags;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    public function test_component_exists_on_the_page()
    {
        $user = User::factory()->create();
        $user->roles()->attach(1);

        $this->actingAs($user);
        $this->get(route('tags'))
            ->assertSeeLivewire(Tags::class);
    }

    public function test_tag_list_page_is_displayed_and_displays_tags(): void
    {
        $user = User::factory()->create();
        $user->roles()->attach(1);

        $tag = Tag::factory()->create();

        Livewire::actingAs($user)
            ->test(Tags::class)
            ->assertSee($tag->name)
            ->assertStatus(200);
    }

    public function test_create_tag_modal_is_displayed(): void
    {
        $user = User::factory()->create();
        $user->roles()->attach(1);

        Livewire::actingAs($user)
            ->test(Tags::class)
            ->call('create')
            ->assertSee(__('Create new tag'))
            ->assertStatus(200);
    }

    public function test_store_tag(): void
    {
        $user = User::factory()->create();
        $user->roles()->attach(1);

        Livewire::actingAs($user)
            ->test(Tags::class)
            ->set('name', 'Nuevo')
            ->call('store')
            ->assertStatus(200)
            ->assertRedirect('/tag');

        Livewire::actingAs($user)
            ->test(Tags::class)
            ->assertSee('Nuevo')
            ->assertStatus(200);
    }

    public function test_edit_tag_modal_is_displayed(): void
    {
        $user = User::factory()->create();
        $user->roles()->attach(1);

        $tag = Tag::factory()->create();

        Livewire::actingAs($user)
            ->test(Tags::class)
            ->call('edit', $tag->id)
            ->assertSee($tag->name)
            ->assertStatus(200);
    }

    public function test_update_tag(): void
    {
        $user = User::factory()->create();
        $user->roles()->attach(1);

        $tag = Tag::factory()->create();

        Livewire::actingAs($user)
            ->test(Tags::class)
            ->set('tag_id', $tag->id)
            ->set('name', 'Nuevo')
            ->call('update')
            ->assertStatus(200)
            ->assertRedirect('/tag');

        Livewire::actingAs($user)
            ->test(Tags::class)
            ->call('edit', $tag->id)
            ->assertSee('name', 'Nuevo')
            ->assertStatus(200);
    }

    public function test_delete_tag(): void
    {
        $user = User::factory()->create();
        $user->roles()->attach(1);

        $tag = Tag::factory()->create();

        Livewire::actingAs($user)
            ->test(Tags::class)
            ->set('tag_id', $tag->id)
            ->call('delete')
            ->assertStatus(200)
            ->assertRedirect('/tag');
    }
}