<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Response;
use App\Http\Requests\Role\StoreRequest;
use App\Http\Requests\Role\UpdateRequest;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('role_index')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        $roles = Role::with('permissions')->get();
        return $this->successResponse($roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('role_add')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        $permissions = Permission::all();
        return $this->successResponse($permissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Role\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        if (Gate::denies('role_add')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        $validated = $request->validated();
        $role = new Role;
        $role->title = $validated['title'];
        $role->save();
        if (isset($validated['permission'])) {
            $role->permissions()->sync($validated['permission']);
        }
        return $this->successResponse('', 'Rol registrado con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        if (Gate::denies('role_index')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        $data['role'] = $role;
        $data['permissions'] = $role->permissions;
        return $this->successResponse($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if (Gate::denies('role_edit')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        if ($role->id == 1 || $role->id == 2) {
            return $this->errorResponse(
                'Editing or deleting parent roles is not allowed. Contact the administrator.', 
                Response::HTTP_FORBIDDEN);
        }
        $data['permissions'] = Permission::all();
        $data['role'] = $role->load('permissions');
        return $this->successResponse($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Role\UpdateRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Role $role)
    {
        if (Gate::denies('role_edit')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        $validated = $request->validated();
        $role->update($validated);
        $role->permissions()->sync($validated['permission']);
        return $this->successResponse('', 'Rol actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if (Gate::denies('role_delete')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        if ($role->id == 1 || $role->id == 2) {
            return $this->errorResponse(
                'Editing or deleting parent roles is not allowed. Contact the administrator.', 
                Response::HTTP_FORBIDDEN);
        }
        $role->delete();
        return $this->successResponse('', 'Rol eliminado con éxito.');
    }
}
