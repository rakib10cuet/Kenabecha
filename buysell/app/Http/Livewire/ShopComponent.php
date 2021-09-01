<?php
namespace App\Http\Livewire;
use App\Models\Category;
use App\Models\Sale;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
class ShopComponent extends Component{
    public $sorting;
    public $pageSize;
    public $minPrice;
    public $maxPrice;
    public function mount(){
        $this->sorting = 'default';
        $this->pageSize = 12;
        $this->minPrice = 1;
        $this->maxPrice = 1000000000;   /*1 Billion*/
    }
    public function store($product_id,$product_name,$product_price){
        Cart::instance('cart')->add($product_id,$product_name,1,$product_price)->associate('App\models\Product');
        session()->flash('success_message','Item Added in Cart');
        return redirect()->route('product.cart');
    }
    public function addToWishList($product_id,$product_name,$product_price){
        Cart::instance('wishlist')->add($product_id,$product_name,1,$product_price)->associate('App\models\Product');
        $this->emitTo('wishlist-count-component','refreshComponent');
    }
    public function removeFromWishList($product_id){
        foreach (Cart::instance('wishlist')->content() as $witems){
            if($witems->id == $product_id){
                Cart::instance('wishlist')->remove($witems->rowId);
                $this->emitTo('wishlist-count-component','refreshComponent');
                return;
            }
        }
    }
    use WithPagination;
    public function render(){
        switch ($this->sorting){
            case 'data':
                $product = Product::whereBetween('regularPrice',[$this->minPrice,$this->maxPrice])->orderBy('created_at')->paginate($this->pageSize);
                break;
            case 'price':
                $product = Product::whereBetween('regularPrice',[$this->minPrice,$this->maxPrice])->orderBy('regularPrice','ASC')->paginate($this->pageSize);
                break;
            case 'price-desc':
                $product = Product::whereBetween('regularPrice',[$this->minPrice,$this->maxPrice])->orderBy('regularPrice','DESC')->paginate($this->pageSize);
                break;
            default:
                $product = Product::whereBetween('regularPrice',[$this->minPrice,$this->maxPrice])->paginate($this->pageSize);
                break;
        }
        $categories = Category::all();
        $popular_product = DB::table('products')->inRandomOrder()->limit(4)->get();
        $sale = Sale::find(1);
        return view('livewire.shop-component',['products'=>$product,'popular_product'=>$popular_product,'categories'=>$categories,'sale'=>$sale])->layout('layouts.base');
    }
}
