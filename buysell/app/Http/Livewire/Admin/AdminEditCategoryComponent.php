<?php
namespace App\Http\Livewire\Admin;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class AdminEditCategoryComponent extends Component{
    public $categorySlug;
    public $categoryId;
    public $name;
    public $slug;
    public function mount($categorySlug){
        $this->categorySlug = $categorySlug;
        $category = Category::where('slug',$categorySlug)->first();
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
    }
    public function generateSlug(){
        $this->slug = Str::slug($this->name);
    }
    public function updated($fields){
        try {
            $this->validateOnly($fields, [
                'name' => 'required',
                'slug' => 'required|unique:categories'
            ]);
        } catch (ValidationException $e) {
        }
    }
    public function updateCategory(){
        $this->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories'
        ]);
        $category = Category::find($this->categoryId);
        $category->name = $this->name;
        $category->slug = $this->slug;
        $category->save();
        session()->flash('message','Category has been updated successfully');
    }
    public function render(){
        return view('livewire.admin.admin-edit-category-component')->layout('layouts.base');
    }
}
