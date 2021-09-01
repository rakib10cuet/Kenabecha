<?php
namespace App\Http\Livewire;
use App\Models\Category;
use App\Models\HomeCategory;
use App\Models\HomeSlider;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
class HomeComponent extends Component{
    public $category;
    public $noOfProducts;
    public function render(){
        /*for slider*/
        $sliders = HomeSlider::where('status',1)->get();
        /*for latest product*/
        $latest_products = Product::orderBy('created_at','DESC')->get()->take(8);
        /*for HomeCategory*/
        $category = HomeCategory::find(1);
        if(!empty($category)){
            $noOfProducts = $category->NoOfProduct;
            $selectCategories_array = explode(',',$category->selectCategories);
            /*for category wise products data*/
            $categories = Category::whereIn('id',$selectCategories_array)->get();
            $categories_products = Product::whereIn('categoryId',$selectCategories_array)->get();
            foreach ($categories_products as $categories_product){
                if(empty($categories_products_associate_array[$categories_product->categoryId])|| count($categories_products_associate_array[$categories_product->categoryId]) < $noOfProducts){
                    $categories_products_associate_array[$categories_product->categoryId][] = $categories_product;
                }
            }
        }else{
            $categories = [];
            $categories_products_associate_array = [];
        }
        /*On Sale Product*/
        $on_sale_products = Product::where('salePrice','>',0)->get()->take(8);
        $sale = Sale::find(1);
        return view('livewire.home-component',['sliders'=>$sliders,'latest_products'=>$latest_products,'categories'=>$categories,'categories_products_associate_array'=>$categories_products_associate_array,'on_sale_products'=>$on_sale_products,'sale'=>$sale])->layout('layouts.base');
    }
}
