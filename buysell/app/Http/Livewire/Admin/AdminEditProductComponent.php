<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
class AdminEditProductComponent extends Component{
    use WithFileUploads;
    public $name;
    public $slug;
    public $shortDescription;
    public $description;
    public $regularPrice;
    public $salePrice;
    public $SKU;
    public $stockStatus;
    public $featured;
    public $quantity;
    public $image;
    public $images;
    public $categoryId;
    public $newimage;
    public $newimages;
    public $productId;
    public function mount($productSlug){
        $product = Product::where('slug',$productSlug)->first();
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->shortDescription = $product->shortDescription;
        $this->description = $product->description;
        $this->regularPrice = $product->regularPrice;
        $this->salePrice = $product->salePrice;
        $this->SKU = $product->SKU;
        $this->stockStatus = $product->stockStatus;
        $this->featured = $product->featured;
        $this->quantity = $product->quantity;
        $this->image = $product->image;
        $this->images = $product->images;
        $this->categoryId = $product->categoryId;
        $this->newimage = $product->newimage;
        $this->newimages = $product->newimages;
        $this->productId = $product->id;
    }
    public function generateSlug(){
        $this->slug = Str::slug($this->name,'-');
    }
    public function updated($fields){
        try {
            $this->validateOnly($fields, [
                'name' => 'required',
                'slug' => 'required|unique:categories',
                'shortDescription' => 'required',
                'description' => 'required',
                'regularPrice' => 'required|numeric',
                'SKU' => 'required',
                'stockStatus' => 'required',
                'quantity' => 'required|numeric',
                'newimage' => 'required|mimes:jpg,png',
                'categoryId' => 'required'
            ]);
        } catch (ValidationException $e) {
        }
    }
    public function updateProduct(){
        try {
            $this->validate([
                'name' => 'required',
                'slug' => 'required|unique:categories',
                'shortDescription' => 'required',
                'description' => 'required',
                'regularPrice' => 'required|numeric',
                'SKU' => 'required',
                'stockStatus' => 'required',
                'quantity' => 'required|numeric',
                'newimage' => 'required|mimes:jpg,png',
                'categoryId' => 'required'
            ]);
        } catch (ValidationException $e) {
        }
        $product = Product::find($this->productId);
        $product->name = $this->name;
        $product->slug = $this->slug;
        $product->shortDescription = $this->shortDescription;
        $product->description = $this->description;
        $product->regularPrice = $this->regularPrice;
        $product->salePrice = $this->salePrice;
        $product->SKU = $this->SKU;
        $product->stockStatus = $this->stockStatus;
        $product->featured = $this->featured;
        $product->quantity = $this->quantity;
        if($this->newimage){
            $imageName = Carbon::now()->timestamp.'.'.$this->newimage->extension();
            $this->newimage->storeAs('products',$imageName);
            $product->image = $imageName;
        }
        if($this->newimages){
            $imagesName = '';
            foreach ($this->newimages as $key=> $image){
                $imgName = Carbon::now()->timestamp.$key.'.'.$image->extension();
                $image->storeAs('products',$imgName);
                $imagesName = (empty($imagesName)) ? $imgName : $imagesName.','.$imgName;
            }
            $product->images = $imagesName;
        }
        $product->categoryId = $this->categoryId;
        $product->save();
        session()->flash('message','Product has been updated successfully');
    }


    public function render(){
        $categories = Category::all();
        return view('livewire.admin.admin-edit-product-component',['categories'=>$categories])->layout('layouts.base');
    }
}
