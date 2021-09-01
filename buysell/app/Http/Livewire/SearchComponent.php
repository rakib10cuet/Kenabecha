<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class SearchComponent extends Component{
    public $sorting;
    public $pageSize;

    public $search;
    public $product_cat;
    public $product_cat_id;

    public function mount(){
        $this->sorting = 'default';
        $this->pageSize = 12;
        $this->fill(request()->only('search','product_cat','product_cat_id'));
    }
    public function store($product_id,$product_name,$product_price){
        Cart::instance('cart')->add($product_id,$product_name,1,$product_price)->associate('Product');  /*error ase solve korte hobe image pay na aitar jonnor  cart e*/
        session()->flash('success_message','Item Added in Cart');
        return redirect()->route('product.cart');
    }
    use WithPagination;
    public function render(){
        switch ($this->sorting){
            case 'data':
                $product = DB::table('products')->where('name','like','%'.$this->search.'%')->where('categoryId','like','%'.$this->product_cat_id.'%')->orderBy('created_at')->paginate($this->pageSize);
                break;
            case 'price':
                $product = DB::table('products')->where('name','like','%'.$this->search.'%')->where('categoryId','like','%'.$this->product_cat_id.'%')->orderBy('regularPrice','ASC')->paginate($this->pageSize);
                break;
            case 'price-desc':
                $product = DB::table('products')->where('name','like','%'.$this->search.'%')->where('categoryId','like','%'.$this->product_cat_id.'%')->orderBy('regularPrice','DESC')->paginate($this->pageSize);
                break;
            default:
                $product = DB::table('products')->where('name','like','%'.$this->search.'%')->where('categoryId','like','%'.$this->product_cat_id.'%')->paginate($this->pageSize);
                break;
        }
        $categories = Category::all();
        $popular_product = DB::table('products')->inRandomOrder()->limit(4)->get();
        return view('livewire.search-component',['products'=>$product,'popular_product'=>$popular_product,'categories'=>$categories])->layout('layouts.base');
    }
}
