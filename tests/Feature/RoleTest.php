<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Response;
use Tests\PassportAdminTestCase;

class RoleTest extends PassportAdminTestCase
{
    public function test_can_list_roles(): void
    {
        $roles = Role::factory(5)->create();

        $response = $this->get(route('role.index'));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_create_role(): void
    {
        $permissions = Permission::factory(2)->create();

        $response = $this->get(route('role.create'));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_store_role() : void
    {
        $permission = Permission::factory()->create();

        $response = $this->post(route('role.store'), [
            'title' => fake()->text(150),
            'created_at' => now(),
            'updated_at' => now(),
            'permission' => [
                $permission->id
            ]
        ]);

        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }
    
    public function test_can_edit_role(): void
    {
        $role = Role::factory()->create();

        $permissions = Permission::factory(2)->create();

        $response = $this->get(route('role.edit', $role->id));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_update_role(): void
    {
        $role = Role::factory()->create();

        $permission = Permission::factory()->create();

        $response = $this->put(route('role.update', $role->id), [
            'title' => fake()->text(25),
            'created_at' => now(),
            'updated_at' => now(),
            'permission' => [
                $permission->id
            ]
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_show_role(): void
    {
        $role = Role::factory()->create();

        $response = $this->get(route('role.show', $role->id));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function test_can_delete_role(): void
    {
        $role = Role::factory()->create();

        $response = $this->delete(route('role.destroy', $role->id));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }
}
