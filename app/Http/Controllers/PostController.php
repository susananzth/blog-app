<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('post_index')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        $posts = Post::with('categories')->with('tags')->get();
        return $this->successResponse($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('post_add')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        $data['categories'] = Category::all();
        $data['tags']       = Tag::all();
        return $this->successResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Post\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        if (Gate::denies('post_add')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        $inputs = $request->validated();

        $post = Post::create($inputs);

        if (isset($inputs['category'])) {
            $post->categories()->attach($inputs['category']);
        }
        if (isset($inputs['tag'])) {
            $post->tags()->attach($inputs['tag']);
        }

        return $this->successResponse(
            $post->load('categories'), 
            'Post register successfully.', 
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if (Gate::denies('post_index')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        return $this->successResponse($post->load('categories')->load('tags'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if (Gate::denies('post_edit')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        $data['post']       = $post->load('categories')->load('tags');
        $data['categories'] = Category::all();
        $data['tags']       = Tag::all();

        return $this->successResponse($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Post\UpdateRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Post $post)
    {
        if (Gate::denies('post_edit')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        $post = Post::find($post)->first();

        $inputs = $request->validated();

        $post->update($inputs);

        $post->categories()->detach();
        if (isset($inputs['category'])) {
            $post->categories()->attach($inputs['category']);
        }
        $post->tags()->detach();
        if (isset($inputs['tag'])) {
            $post->tags()->attach($inputs['tag']);
        }

        return $this->successResponse(
            $post->load('categories')->load('tags'), 'Post updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (Gate::denies('post_delete')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        Post::destroy($post->id);

        return $this->successResponse('', 'Post deleted successfully.', Response::HTTP_OK);
    }
}
