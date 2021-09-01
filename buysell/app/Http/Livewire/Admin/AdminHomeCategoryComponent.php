<?php
namespace App\Http\Livewire\Admin;
use App\Models\Category;
use App\Models\HomeCategory;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class AdminHomeCategoryComponent extends Component{
    public $selectedCategories = [];
    public $numberOfProducts;
    public function mount(){
        $category = HomeCategory::find(1);
        if(!empty($category)){
            $this->selectedCategories = explode(',',$category->selectCategories);
            $this->numberOfProducts = $category->NoOfProduct;
        }
    }
    public function updated($fields){
        try {
            $this->validateOnly($fields, [
                'selectedCategories' => 'required',
            'numberOfProducts' => 'required|numeric'
            ]);
        } catch (ValidationException $e) {
        }
    }
    public function updateHomeCategory(){
        $this->validate([
            'selectedCategories' => 'required',
            'numberOfProducts' => 'required|numeric'
        ]);
        $category = HomeCategory::find(1);
        if(!empty($category)){
            $category->selectCategories = implode(',',$this->selectedCategories);
            $category->NoOfProduct = $this->numberOfProducts;
            $category->save();
        }else{
            $category = new HomeCategory();
            $category->selectCategories = implode(',',$this->selectedCategories);
            $category->NoOfProduct = $this->numberOfProducts;
            $category->save();
        }

        session()->flash('message','HomeCategory has been updated successfully');

    }

    public function render(){
        $categories = Category::all();
        return view('livewire.admin.admin-home-category-component',['categories'=>$categories])->layout('layouts.base');
    }
}
