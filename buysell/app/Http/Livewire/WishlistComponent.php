<?php

namespace App\Http\Livewire;

use  App\Models\Sale;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class WishlistComponent extends Component{
    public function moveProductFromWishListToCart($rowId){
        $item = Cart::instance('wishlist')->get($rowId);
        Cart::instance('wishlist')->remove($rowId);
        Cart::instance('cart')->add($item->id,$item->name,1,$item->price)->associate('App\models\Product');
        $this->emitTo('wishlist-count-component','refreshComponent');
        $this->emitTo('cart-count-component','refreshComponent');
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
    public function render(){
        $sale = Sale::find(1);
        return view('livewire.wishlist-component',['sale'=>$sale])->layout('layouts.base');
    }
}
