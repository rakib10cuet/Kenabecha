<?php
namespace App\Http\Livewire;
use App\Models\Coupon;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CartComponent extends Component{
    public $haveCouponCode;
    public $couponCode;
    public $discount;
    public $subTotalAfterDiscount;
    public $taxAfterDiscount;
    public $totalAfterDiscount;

    public function increaseQuantity($rowId){
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId,$qty);
        $this->emitTo('cart-count-component','refreshComponent');
    }
    public function decreaseQuantity($rowId){
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($rowId,$qty);
        $this->emitTo('cart-count-component','refreshComponent');
    }
    public function destroy($rowId){
        Cart::instance('cart')->remove($rowId);
        $this->emitTo('cart-count-component','refreshComponent');
        session()->flash('success_message','Item has been removed');
    }
    public function destroyAll(){
        Cart::destroy();
        $this->emitTo('cart-count-component','refreshComponent');
    }
    public function switchToSaveForLater($rowId){
        $item = Cart::instance('cart')->get($rowId);
        Cart::instance('cart')->remove($rowId);
        Cart::instance('saveForLater')->add($item->id,$item->name,1,$item->price)->associate('app\Models\Product');;
        $this->emitTo('cart-count-component','refreshComponent');
        session()->flash('success_message','Item has been saved for Later');
    }
    public function moveToCart($rowId){
        $item = Cart::instance('saveForLater')->get($rowId);
        Cart::instance('saveForLater')->remove($rowId);
        Cart::instance('cart')->add($item->id,$item->name,1,$item->price)->associate('app\Models\Product');;
        $this->emitTo('cart-count-component','refreshComponent');
        session()->flash('s_success_message','Item has been moved to cart');
    }
    public function deleteFromSaveForLater($rowId){
        Cart::instance('saveForLater')->remove($rowId);
        session()->flash('s_success_message','Item has been removed from save for later');
    }
    public function applyCouponCode(){
        $coupon = Coupon::where('code',$this->couponCode)->where('expiryDate','>=',Carbon::today())->where('cartValue','<=',Cart::instance('cart')->subtotal())->first();
        if(!$coupon){
            session()->flash('coupon_message','Coupon code is invalid!!');
            return;
        }else{
            session()->put('coupon',[
                'code'=> $coupon->code,
                'type'=> $coupon->type,
                'value'=> $coupon->value,
                'cartValue'=> $coupon->cartValue
            ]);
        }
    }
    public function calculateDiscount(){
        if(session()->has('coupon')){
            $sessionCouponData = session()->get('coupon');
            $cartSubtotal= Cart::instance('cart')->subtotal();
//            if($sessionCouponData['type'] == 'fixed'){
//                $this->discount = $sessionCouponData['value'];
//            }else{
//                $this->discount = (Cart::instance('cart')->subtotal() * $sessionCouponData['value'])/100;
//            }
//            $this->discount = ($sessionCouponData['type'] == 'fixed') ? $sessionCouponData['value'] : (Cart::instance('cart')->subtotal() * $sessionCouponData['value'])/100;
            $this->discount = ($sessionCouponData['type'] == 'fixed') ? $sessionCouponData['value'] : ($cartSubtotal * $sessionCouponData['value'])/100;
            $this->subTotalAfterDiscount = $cartSubtotal - $this->discount;
            $this->taxAfterDiscount = ($this->subTotalAfterDiscount * config('cart.tax'))/100;
            $this->totalAfterDiscount = $this->subTotalAfterDiscount + $this->taxAfterDiscount;
        }
    }
    public function removeCoupon(){
        session()->forget('coupon');
    }
    public function checkOut(){
        if(Auth::check()){
            return redirect()->route('checkout');
        }else{
            return redirect()->route('login');
        }
    }
    public function setAmountForCheckout(){
        if(!Cart::instance('cart')->count() > 0){
            session()->forget('checkout');
        }
        if(session()->has('coupon')){
            session()->put('checkout',[
                'discount'=> $this->discount,
                'subtotal'=> $this->subTotalAfterDiscount,
                'tax'=> $this->taxAfterDiscount,
                'total'=> $this->totalAfterDiscount
            ]);
        }else{
            session()->put('checkout',[
                'discount'=> 0,
                'subtotal'=> Cart::instance('cart')->subtotal(),
                'tax'=> Cart::instance('cart')->tax(),
                'total'=> Cart::instance('cart')->total()
            ]);
        }
    }
    public function render(){
        if(session()->has('coupon')){
            $sessionCouponData = session()->get('coupon');
            $cartSubtotal= Cart::instance('cart')->subtotal();
            if($cartSubtotal < $sessionCouponData['cartValue']){
                session()->forget('coupon');
            }else{
                $this->calculateDiscount();
            }
        }
        $this->setAmountForCheckout();
        $popular_product = DB::table('products')->inRandomOrder()->limit(10)->get();
        return view('livewire.cart-component',['popular_product'=>$popular_product])->layout('layouts.base');
    }
}
