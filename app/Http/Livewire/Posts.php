<?php

namespace App\Http\Livewire;

use DB;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Posts extends Component
{
    use WithPagination;

    public $users, $title, $slug, $image, $imageEdit, $body, $status, $user_name, $post_id;
    public $addPost = false, $updatePost = false, $deletePost = false;

    protected $listeners = ['render'];

    #[Title('Posts')]
    public function rules()
    {
        return PostRequest::rules($this->post_id);
    }

    public function resetFields()
    {
        $this->title = '';
        $this->slug = '';
        $this->image = '';
        $this->imageEdit = '';
        $this->body = '';
        $this->status = '';
        $this->users = [];
        $this->user_name = '';
    }

    public function resetValidationAndFields()
    {
        $this->resetValidation();
        $this->resetFields();
        $this->addPost = false;
        $this->updatePost = false;
        $this->deletePost = false;
    }

    public function mount()
    {
        if (Gate::denies('post_index')) {
            return redirect()->route('dashboard')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
    }

    public function render()
    {
        $posts = Post::orderBy('updated_at', 'desc')->paginate(10);
        return view('post.index', compact('posts'));
    }

    public function create()
    {
        if (Gate::denies('post_add')) {
            return redirect()->route('posts')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        $this->post_id = '';
        $this->addPost = true;
        return view('post.create');
    }

    public function store()
    {
        if (Gate::denies('post_add')) {
            return redirect()->route('posts')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
        $this->validate();

        $user_id = Auth::id();

        DB::beginTransaction();
        $post = Post::create([
            'title'   => $this->title,
            'slug'    => Str::slug($this->title, '-'),
            'body'    => $this->body,
            'user_id' => $user_id,
            'status'  => $this->status,
        ]);
        $post->save();
        DB::commit();

        DB::beginTransaction();
        if ($this->image != '') {
            if ($post->image) {
                if (Storage::exists('public/images/'.$post->image->url)) {
                    Storage::delete('public/images/'.$post->image->url);
                }
                $post->image->delete();
            }
            $file = $this->image->storePublicly('public/images');
            $post->image()->create([
                'url' => substr($file, strlen('public/images/')),
            ]);
        }
        DB::commit();

        return redirect()->route('posts')
            ->with('message', trans('message.Created Successfully.', ['name' => __('Post')]))
            ->with('alert_class', 'success');
    }


    public function edit($id)
    {
        if (Gate::denies('post_edit')) {
            return redirect()->route('posts')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $post = Post::find($id);

        if (!$post) {
            return redirect()->route('posts')
                ->with('message', 'Post not found')
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        $this->post_id   = $post->id;
        $this->title     = $post->title;
        $this->slug      = $post->slug;
        $this->user_name = $post->user->first_name . ' ' . $post->user->last_name;
        $this->imageEdit = $post->image->url ?? '';
        $this->body      = $post->body;
        $this->status    = $post->status;
        $this->updatePost = true;
        return view('post.edit');
    }

    public function update()
    {
        if (Gate::denies('post_edit')) {
            return redirect()->route('posts')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $this->validate();

        $post = Post::find($this->post_id);
        if (!$post) {
            return redirect()->route('posts')
                ->with('message', 'Post not found')
                ->with('alert_class', 'danger');
        }

        DB::beginTransaction();
        $post->title      = $this->title;
        $post->slug       = $this->slug;
        $post->body       = $this->body;
        $post->status       = $this->status;
        $post->image->url = $this->image;
        if ($this->image != '') {
            if ($post->image) {
                if (Storage::exists('public/images/'.$post->image->url)) {
                    Storage::delete('public/images/'.$post->image->url);
                }
                $post->image->delete();
            }
            $file = $this->image->storePublicly('public/images');
            $post->image()->create([
                'url' => substr($file, strlen('public/images/')),
            ]);
        }
        $post->save();
        DB::commit();

        return redirect()->route('posts')
            ->with('message', trans('message.Updated Successfully.', ['name' => __('Post')]))
            ->with('alert_class', 'success');
    }

    public function cancel()
    {
        $this->resetValidationAndFields();
    }

    public function setDeleteId($id)
    {
        if (Gate::denies('post_delete')) {
            return redirect()->route('posts')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $post = Post::find($id);
        if (!$post) {
            return redirect()->route('posts')
                ->with('message', 'Post not found')
                ->with('alert_class', 'danger');
        }
        $this->post_id = $post->id;
        $this->resetValidationAndFields();
        $this->deletePost = true;
    }

    public function delete()
    {
        if (Gate::denies('post_delete')) {
            return redirect()->route('posts')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $post = Post::find($this->post_id);
        if (!$post) {
            return redirect()->route('posts')
                ->with('message', 'Post not found')
                ->with('alert_class', 'danger');
        }
        if (isset($post->image) && Storage::exists('public/images/'.$post->image->url)) {
            Storage::delete('public/images/'.$post->image->url);
        }
        DB::beginTransaction();
        $post->delete();
        DB::commit();

        return redirect()->route('posts')
            ->with('message', trans('message.Deleted Successfully.', ['name' => __('Post')]))
            ->with('alert_class', 'success');
    }
}