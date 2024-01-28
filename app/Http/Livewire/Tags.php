<?php

namespace App\Http\Livewire;

use DB;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Tags extends Component
{
    use WithPagination;

    public $name, $tag_id;
    public $addTag = false, $updateTag = false, $deleteTag = false;

    protected $listeners = ['render'];

    #[Title('Tags')]
    public function rules()
    {
        return TagRequest::rules($this->tag_id);
    }

    public function resetFields()
    {
        $this->name = '';
    }

    public function resetValidationAndFields()
    {
        $this->resetValidation();
        $this->resetFields();
        $this->addTag = false;
        $this->updateTag = false;
        $this->deleteTag = false;
    }

    public function mount()
    {
        if (Gate::denies('tag_index')) {
            return redirect()->route('dashboard')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
    }

    public function render()
    {
        $tags = Tag::orderBy('name', 'asc')->paginate(10);
        return view('tag.index', compact('tags'));
    }

    public function create()
    {
        if (Gate::denies('tag_add')) {
            return redirect()->route('tags')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        $this->tag_id = '';
        $this->addTag = true;
        return view('tag.create');
    }

    public function store()
    {
        if (Gate::denies('tag_add')) {
            return redirect()->route('tags')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
        $this->validate();

        DB::beginTransaction();
        $tag = Tag::create([
            'name' => $this->name,
        ]);
        $tag->save();
        DB::commit();

        return redirect()->route('tags')
            ->with('message', trans('message.Created Successfully.', ['name' => __('Tag')]))
            ->with('alert_class', 'success');
    }

    public function edit($id)
    {
        if (Gate::denies('tag_edit')) {
            return redirect()->route('tags')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $tag = Tag::find($id);

        if (!$tag) {
            return redirect()->route('tags')
                ->with('message', 'Tag not found')
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        $this->tag_id    = $tag->id;
        $this->name      = $tag->name;
        $this->updateTag = true;
        return view('tag.edit');
    }

    public function update()
    {
        if (Gate::denies('tag_edit')) {
            return redirect()->route('tags')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $this->validate();

        $tag = tag::find($this->tag_id);
        if (!$tag) {
            return redirect()->route('tags')
                ->with('message', 'Tag not found')
                ->with('alert_class', 'danger');
        }

        DB::beginTransaction();
        $tag->name = $this->name;
        $tag->save();
        DB::commit();

        return redirect()->route('tags')
            ->with('message', trans('message.Updated Successfully.', ['name' => __('Tag')]))
            ->with('alert_class', 'success');
    }

    public function cancel()
    {
        $this->resetValidationAndFields();
    }

    public function setDeleteId($id)
    {
        if (Gate::denies('tag_delete')) {
            return redirect()->route('tags')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $tag = Tag::find($id);
        if (!$tag) {
            return redirect()->route('tags')
                ->with('message', 'Tag not found')
                ->with('alert_class', 'danger');
        }
        $this->tag_id = $tag->id;
        $this->resetValidationAndFields();
        $this->deleteTag = true;
    }

    public function delete()
    {
        if (Gate::denies('tag_delete')) {
            return redirect()->route('tags')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $tag = Tag::find($this->tag_id);
        if (!$tag) {
            return redirect()->route('tags')
                ->with('message', 'Tag not found')
                ->with('alert_class', 'danger');
        }

        DB::beginTransaction();
        $tag->delete();
        DB::commit();
        return redirect()->route('tags')
            ->with('message', trans('message.Deleted Successfully.', ['name' => __('Tag')]))
            ->with('alert_class', 'success');
    }
}