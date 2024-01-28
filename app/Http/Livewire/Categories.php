<?php

namespace App\Http\Livewire;

use DB;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Categories extends Component
{
    use WithFileUploads, WithPagination;

    public $name, $image, $imageEdit, $status, $category_id;
    public $addCategory = false, $updateCategory = false, $deleteCategory = false;

    protected $listeners = ['render'];

    #[Title('Categories')]
    public function rules()
    {
        return CategoryRequest::rules($this->category_id);
    }

    public function resetFields()
    {
        $this->name = '';
        $this->image = '';
        $this->imageEgit = '';
        $this->status = '';
    }

    public function resetValidationAndFields()
    {
        $this->resetValidation();
        $this->resetFields();
        $this->addCategory = false;
        $this->updateCategory = false;
        $this->deleteCategory = false;
    }

    public function mount()
    {
        if (Gate::denies('category_index')) {
            return redirect()->route('dashboard')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
    }

    public function render()
    {
        $categories = Category::orderBy('name', 'asc')->paginate(10);
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        if (Gate::denies('category_add')) {
            return redirect()->route('categories')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        $this->category_id = '';
        $this->addCategory = true;
        return view('category.create');
    }

    public function store()
    {
        if (Gate::denies('category_add')) {
            return redirect()->route('categories')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
        $this->validate();

        DB::beginTransaction();
        $category = Category::create([
            'name' => $this->name,
        ]);
        $category->save();
        DB::commit();

        DB::beginTransaction();
        if ($this->image != '') {
            if ($category->image) {
                if (Storage::exists('public/images/'.$category->image->url)) {
                    Storage::delete('public/images/'.$category->image->url);
                }
                $category->image->delete();
            }
            $file = $this->image->storePublicly('public/images');
            $category->image()->create([
                'url' => substr($file, strlen('public/images/')),
            ]);
        }
        DB::commit();

        return redirect()->route('categories')
            ->with('message', trans('message.Created Successfully.', ['name' => __('Category')]))
            ->with('alert_class', 'success');
    }

    public function edit($id)
    {
        if (Gate::denies('category_edit')) {
            return redirect()->route('categories')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('categories')
                ->with('message', 'Category not found')
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        $this->category_id    = $category->id;
        $this->name           = $category->name;
        $this->image          = $category->image->url ?? null;
        $this->imageEdit      = $category->image->url ?? null;
        $this->status         = $category->status;
        $this->updateCategory = true;
        return view('category.edit');
    }

    public function update()
    {
        if (Gate::denies('category_edit')) {
            return redirect()->route('categories')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $this->validate();

        $category = Category::find($this->category_id);
        if (!$category) {
            return redirect()->route('categories')
                ->with('message', 'Category not found')
                ->with('alert_class', 'danger');
        }

        if (gettype($this->image) != 'string' && $this->image != '') {
            $file = $this->image->storePublicly('public/images');
            $this->image = substr($file, strlen('public/images/'));
            if (Storage::exists('public/images/'.$category->image->url)) {
                Storage::delete('public/images/'.$category->image->url);
            }
        } else {
            $this->image = $category->image->url;
        }

        DB::beginTransaction();
        $category->name       = $this->name;
        $category->status     = $this->status;
        $category->image->url = $this->image;
        $category->image->save();
        $category->save();
        DB::commit();

        return redirect()->route('categories')
            ->with('message', trans('message.Updated Successfully.', ['name' => __('Category')]))
            ->with('alert_class', 'success');
    }

    public function cancel()
    {
        $this->resetValidationAndFields();
    }

    public function setDeleteId($id)
    {
        if (Gate::denies('category_delete')) {
            return redirect()->route('categories')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $category = Category::find($id);
        if (!$category) {
            return redirect()->route('categories')
                ->with('message', 'Category not found')
                ->with('alert_class', 'danger');
        }
        $this->category_id = $category->id;
        $this->resetValidationAndFields();
        $this->deleteCategory = true;
    }

    public function delete()
    {
        if (Gate::denies('category_delete')) {
            return redirect()->route('categories')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $category = Category::find($this->category_id);
        if (!$category) {
            return redirect()->route('categories')
                ->with('message', 'Category not found')
                ->with('alert_class', 'danger');
        }
        if (Storage::exists('public/images/'.$category->image->url)) {
            Storage::delete('public/images/'.$category->image->url);
        }

        DB::beginTransaction();
        $category->delete();
        DB::commit();

        return redirect()->route('categories')
            ->with('message', trans('message.Deleted Successfully.', ['name' => __('Category')]))
            ->with('alert_class', 'success');
    }
}