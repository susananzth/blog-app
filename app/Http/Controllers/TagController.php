<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Tag\StoreRequest;
use App\Http\Requests\Tag\UpdateRequest;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('tag_index')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        $tags = Tag::all();
        return $this->successResponse($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Tag\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        if (Gate::denies('tag_add')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        $inputs = $request->validated();

        $tag = Tag::create($inputs);

        return $this->successResponse(
            $tag, 
            'Tag register successfully.', 
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        if (Gate::denies('tag_index')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        return $this->successResponse($tag);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        if (Gate::denies('tag_edit')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        return $this->successResponse($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Tag\UpdateRequest  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Tag $tag)
    {
        if (Gate::denies('tag_edit')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        $tag = Tag::find($tag)->first();

        $inputs = $request->validated();

        $tag->update($inputs);

        return $this->successResponse($tag, 'Tag updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        if (Gate::denies('tag_delete')) {
            return $this->errorResponse(
                '403 Forbidden', 
                Response::HTTP_FORBIDDEN);
        }
        $tag = Tag::find($tag->id);
        if (count($tag->posts) == 0) {
            Tag::destroy($tag->id);

            return $this->successResponse('', 'Tag deleted successfully.', Response::HTTP_OK);
        } else {
            return $this->errorResponse(
                'The tag cannot be removed because it is associated with posts',
                Response::HTTP_UNPROCESSABLE_ENTITY 
            );
        }

    }
}
