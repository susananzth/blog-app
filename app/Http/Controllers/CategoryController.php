<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Response;
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
        return $this->successResponse(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Category\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $inputs = $request->validated();

        $category = Category::create($inputs);

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
        $category = Category::find($category)->first();

        $inputs = $request->validated();

        $category->update($inputs);

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
        Category::destroy($category->id);

        return $this->successResponse('', 'Category deleted successfully.', Response::HTTP_OK);
    }
}
