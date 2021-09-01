<?php
namespace App\Http\Livewire;
use App\Models\Category;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryComponent extends Component{
    public $sorting;
    public $pageSize;
    public $categorySlug;

    public function mount($categorySlug){
        $this->sorting = 'default';
        $this->pageSize = 12;
        $this->categorySlug = $categorySlug;
    }
    public function store($product_id,$product_name,$product_price){
        Cart::instance('cart')->add($product_id,$product_name,1,$product_price)->associate('App\models\Product');
        session()->flash('success_message','Item Added in Cart');
        return redirect()->route('product.cart');
    }
    use WithPagination;
    public function render(){
        $category = Category::where('slug',$this->categorySlug)->first();
        $categoryId = $category->id;
        $categoryName = $category->name;
        switch ($this->sorting){
            case 'data':
                $product = DB::table('products')->where('categoryId',$categoryId)->orderBy('created_at')->paginate($this->pageSize);
                break;
            case 'price':
                $product = DB::table('products')->where('categoryId',$categoryId)->orderBy('regularPrice','ASC')->paginate($this->pageSize);
                break;
            case 'price-desc':
                $product = DB::table('products')->where('categoryId',$categoryId)->orderBy('regularPrice','DESC')->paginate($this->pageSize);
                break;
            default:
                $product = DB::table('products')->where('categoryId',$categoryId)->paginate($this->pageSize);
                break;
        }
        $categories = Category::all();
        $popular_product = DB::table('products')->inRandomOrder()->limit(4)->get();
        return view('livewire.category-component',['products'=>$product,'popular_product'=>$popular_product,'categories'=>$categories,'categoryName'=>$categoryName])->layout('layouts.base');
    }
}
