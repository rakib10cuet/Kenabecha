<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipping;
use App\Models\Transaction;
//use Gloudemans\Shoppingcart\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Cart;
use Stripe;

class CheckoutComponent extends Component{
    /*for order table*/
    public $shipToDifferent;
    public $firstName;
    public $lastName;
    public $email;
    public $mobile;
    public $line1;
    public $line2;
    public $city;
    public $province;
    public $country;
    public $zipcode;
    /*for shipping table*/
    public $shippingFirstName;
    public $shippingLastName;
    public $shippingEmail;
    public $shippingMobile;
    public $shippingLine1;
    public $shippingLine2;
    public $shippingcountry;
    public $shippingProvince;
    public $shippingCity;
    public $shippingZipcode;
    /*for transactions table*/
    public $paymentMode;
    /*for thank you Message*/
    public $thankyou;

    /*for card payment*/
    public $cardNo;
    public $exp_month;
    public $exp_year;
    public $cvc;


    public function updated($fields){
        try {
            $this->validateOnly($fields, [
                'firstName' => 'required',
                'lastName' => 'required',
                'email' => 'required|email',
                'mobile' => 'required|numeric',
                'line1' => 'required',
                'line2' => 'required',
                'city' => 'required',
                'province' => 'required',
                'country' => 'required',
                'zipcode' => 'required',
                'paymentMode' => 'required',
            ]); /*for order table*/
            if($this->shipToDifferent){
                $this->validateOnly($fields,[
                    'shippingFirstName' => 'required',
                    'shippingLastName' => 'required',
                    'shippingEmail' => 'required|email',
                    'shippingMobile' => 'required|numeric',
                    'shippingLine1' => 'required',
                    'shippingLine2' => 'required',
                    'shippingcountry' => 'required',
                    'shippingProvince' => 'required',
                    'shippingCity' => 'required',
                    'shippingZipcode' => 'required'
                ]);

            }   /*for shipping table*/
            if($this->paymentMode == 'card'){
                $this->validateOnly($fields,[
                    'cardNo' => 'required|numeric',
                    'exp_month' => 'required|numeric',
                    'exp_year' => 'required|email|numeric',
                    'cvc' => 'required|numeric|numeric',
                ]);

            }   /*for Card Payment info*/
        } catch (ValidationException $e) {
//            session()->flash('stripeError',$e->getMessage());
            $this->thankyou = 0;
        }
    }
    public function placeOrder(){
        /*for order table*/
        $this->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'line1' => 'required',
            'line2' => 'required',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
            'zipcode' => 'required',
            'paymentMode' => 'required',
        ]);
        $order = new Order();
        $order->userId = Auth::user()->id;
        $order->subtotal = session()->get('checkout')['subtotal'];
        $order->discount = session()->get('checkout')['discount'];
        $order->tax = session()->get('checkout')['tax'];
        $order->total = session()->get('checkout')['total'];
        $order->firstName = $this->firstName;
        $order->lastName = $this->lastName;
        $order->email = $this->email;
        $order->mobile = $this->mobile;
        $order->line1 = $this->line1;
        $order->line2 = $this->line2;
        $order->city = $this->city;
        $order->province = $this->province;
        $order->country = $this->country;
        $order->zipcode = $this->zipcode;
        $order->status = 1;
        $order->isShippingDifferent = $this->shipToDifferent ? 1 : 0;
        $order->save();
        /*for orderItem table*/
        foreach (Cart::instance('cart')->content() as $item){
            $orderItem = new OrderItem();
            $orderItem->productId = $item->id;
            $orderItem->orderId = $order->id;
            $orderItem->price = $item->price;
            $orderItem->quantity = $item->qty;
            $orderItem->save();
        }
        /*for Shipping table*/
        if($this->shipToDifferent){
            $this->validate([
                'shippingFirstName' => 'required',
                'shippingLastName' => 'required',
                'shippingEmail' => 'required|email',
                'shippingMobile' => 'required|numeric',
                'shippingLine1' => 'required',
                'shippingLine2' => 'required',
                'shippingcountry' => 'required',
                'shippingProvince' => 'required',
                'shippingCity' => 'required',
                'shippingZipcode' => 'required'
            ]);
            $shipping = new Shipping();
            $shipping->orderId = $order->id;
            $shipping->firstName = $this->shippingFirstName;
            $shipping->lastName = $this->shippingLastName;
            $shipping->email = $this->shippingEmail;
            $shipping->mobile = $this->shippingMobile;
            $shipping->line1 = $this->shippingLine1;
            $shipping->line2 = $this->shippingLine2;
            $shipping->city = $this->shippingCity;
            $shipping->province = $this->shippingProvince;
            $shipping->country = $this->shippingcountry;
            $shipping->zipcode = $this->shippingZipcode;
            $shipping->save();
        }
        /*for Payment*/
        if($this->paymentMode == 'cod'){
            $this->makeTransaction($order->id,'pending');
            $this->thanksAndResetCart();
        }else if ($this->paymentMode == 'card'){
            $stripe = Stripe::make(env('STRIPE_KEY'));
            try {
                $token = $stripe->tokens()->create([
                    'card' => [
                        'number' => $this->cardNo,
                        'exp_month' => $this->exp_month,
                        'exp_year' => $this->exp_year,
                        'cvc' => $this->cvc
                    ]
                ]);
                if(!isset($token['id'])){
                    session()->flash('stripeError','The stripe token was not generated correctly');
                    $this->thankyou = 0;
                }
                $customer = $stripe->customers()->create([
                    'name' => $this->firstName . ' ' . $this->lastName,
                    'email' => $this->email,
                    'phone' => $this->mobile,
                    'address' => [
                        'line1' =>$this->line1,
                        'postal_code' => $this->zipcode,
                        'city' => $this->city,
                        'state' => $this->province,
                        'country' => $this->country
                    ],
                    'shipping' => [
                        'name' => $this->firstName . ' ' . $this->lastName,
                        'address' => [
                            'line1' =>$this->line1,
                            'postal_code' => $this->zipcode,
                            'city' => $this->city,
                            'state' => $this->province,
                            'country' => $this->country
                        ],
                    ],
                    'source' => $token['id']
                ]);
                $charge = $stripe->charges()->create([
                    'customer' => $customer['id'],
                    'currency' => 'USD',
                    'amount' => session()->get('checkout')['total'],
                    'description' => 'Payment For order no' . 1
//                'description' => 'Payment For order no' . $order->id
                ]);
                if($charge['status'] == 'succeeded'){
                    $this->makeTransaction($order->id,'approved');
                    $this->thanksAndResetCart();
                }else{
                    session()->flash('stripeError','Error in Transaction!');
                    $this->thankyou = 0;
                }
            }catch (\Exception $e) {
                $this->thankyou = 0;
            }
        }
    }

    public function makeTransaction($orderId,$status){
        $transaction = new Transaction();
        $transaction->userId = Auth::user()->id;
        $transaction->orderId = $orderId;
        $transaction->mode = $this->paymentMode;
        $transaction->status = $status;
        $transaction->save();
    }
    public function thanksAndResetCart(){
        /*for thank you Message*/
        $this->thankyou = 1;
        /*cart empty for reuse*/
        Cart::instance('cart')->destroy();
        session()->forget('checkout');
    }
    public function verifyForCheckout(){
        if(!Auth::check()){
            return redirect()->route('login');
        }else if($this->thankyou){
            return redirect()->route('thankyou');
        }else if(!session()->get('checkout')){
            return redirect()->route('product.cart');
        }
    }
    public function render(){
        $this->verifyForCheckout();
        return view('livewire.checkout-component')->layout('layouts.base');
    }
}
