<?php
namespace App\Http\Livewire\Admin;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminAddProductComponent extends Component{
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
    public $categoryId;
    public $images;


    public function mount(){
        $this->stockStatus = 'instock';
        $this->featured = 0;
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
                'image' => 'required|mimes:jpg,png',
                'categoryId' => 'required'
            ]);
        } catch (ValidationException $e) {
        }
    }

    public function addProduct(){
        $this->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories',
            'shortDescription' => 'required',
            'description' => 'required',
            'regularPrice' => 'required|numeric',
            'SKU' => 'required',
            'stockStatus' => 'required',
            'quantity' => 'required|numeric',
            'image' => 'required|mimes:jpg,png',
            'categoryId' => 'required'
        ]);
        $product = new Product();
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
        $imageName = Carbon::now()->timestamp.'.'.$this->image->extension();
        $this->image->storeAs('products',$imageName);
        $product->image = $imageName;
        if($this->images){
            $imagesName = '';
            foreach ($this->images as $key=> $image){
                $imgName = Carbon::now()->timestamp.$key.'.'.$image->extension();
                $image->storeAs('products',$imgName);
                $imagesName = (empty($imagesName)) ? $imgName : $imagesName.','.$imgName;
            }
            $product->images = $imagesName;
        }
        $product->categoryId = $this->categoryId;
        $product->save();
        session()->flash('message','Product has been created successfully');
    }


    public function render(){
        $categories = Category::all();
        return view('livewire.admin.admin-add-product-component',['categories'=>$categories])->layout('layouts.base');
    }
}
