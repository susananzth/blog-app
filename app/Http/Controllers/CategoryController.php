<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('category_index')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        $firebase = app('firebase.storage');
        $bucket   = $firebase->getBucket();
        
        $categories = Category::all()->load('image');
        foreach ($categories as $category) {
            if ($category->image != null) {
                $object   = $bucket->object('images/' . $category->image->name);
                $url      = $object->signedUrl(new \DateTime('tomorrow'));
                $category->image->url = $url;
            }
        }
        return $this->successResponse($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Category\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        if (Gate::denies('category_add')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        $inputs = $request->validated();

        $category = Category::create($inputs);

        if (isset($inputs['image'])) {
            $filename = rand(0000, 9999).time().'.'.$inputs['image']->extension();
            // Almacenar imagen
            $firebase = app('firebase.storage');
            $bucket   = $firebase->getBucket();
            $file     = $inputs['image'];
            $bucket->upload(fopen($file->getPathname(), 'r'), ['name' => 'images/' . $filename]);

            $image = new Image();
            $image->name = $filename;
            $image->imageable()->associate($category);
            $image->save();

            $category = $category->load('image');
            $object   = $bucket->object('images/' . $category->image->name);
            $url      = $object->signedUrl(new \DateTime('tomorrow'));
            $category->image->url = $url;
        }

        return $this->successResponse(
            $category, 
            'Category register successfully.', 
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        if (Gate::denies('category_index')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        $category = $category->load('image');
        if ($category->image != null) {
            $firebase = app('firebase.storage');
            $bucket   = $firebase->getBucket();
            $object   = $bucket->object('images/' . $category->image->name);
            $url      = $object->signedUrl(new \DateTime('tomorrow'));
            $category->image->url = $url;
        }
        return $this->successResponse($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if (Gate::denies('category_edit')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        $category = $category->load('image');
        if ($category->image != null) {
            $firebase = app('firebase.storage');
            $bucket   = $firebase->getBucket();
            $object   = $bucket->object('images/' . $category->image->name);
            $url      = $object->signedUrl(new \DateTime('tomorrow'));
            $category->image->url = $url;
        }
        return $this->successResponse($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Category\UpdateRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Category $category)
    {
        if (Gate::denies('category_edit')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        $category = Category::find($category)->first();

        $inputs = $request->validated();

        $category->update($inputs);

        if (isset($inputs['image'])) {
            $filename = rand(0000, 9999).time().'.'.$inputs['image']->extension();
            // Almacenar imagen
            $firebase = app('firebase.storage');
            $bucket   = $firebase->getBucket();
            $file     = $inputs['image'];
            $bucket->upload(fopen($file->getPathname(), 'r'), ['name' => 'images/' . $filename]);
            if ($category->image->name != null) {
                // Elimina imagen anterior para almacenar la nueva
                $object   = $bucket->object('images/' . $category->image->name);
                $url      = $object->delete();
                $category->image()->delete();
            }
            $image = new Image();
            $image->name = $filename;
            $image->imageable()->associate($category);
            $image->save();
        }

        $category = $category->load('image');
        if ($category->image != null) {
            $firebase = app('firebase.storage');
            $bucket   = $firebase->getBucket();
            $object   = $bucket->object('images/' . $category->image->name);
            $url      = $object->signedUrl(new \DateTime('tomorrow'));
            $category->image->url = $url;
        }

        return $this->successResponse($category, 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if (Gate::denies('category_delete')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        if ($category->image->name != null) {
            $firebase = app('firebase.storage');
            $bucket   = $firebase->getBucket();
            $object   = $bucket->object('images/' . $category->image->name);
            $url      = $object->delete();
        }
        if ($category->image) {
            $category->image()->delete();
        }
        Category::destroy($category->id);

        return $this->successResponse('', 'Category deleted successfully.', Response::HTTP_OK);
    }
}
