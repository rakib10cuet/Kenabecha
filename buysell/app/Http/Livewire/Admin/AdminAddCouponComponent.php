<?php

namespace App\Http\Livewire\Admin;

use App\Models\Coupon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class AdminAddCouponComponent extends Component{
    public $Test;
    public $code;
    public $type;
    public $value;
    public $cartValue;
    public $expiryDate;
    public function updated($fields){
        try {
            $this->validateOnly($fields, [
                'code' => 'required|unique:coupons',
                'type' => 'required',
                'value' => 'required|numeric',
                'cartValue' => 'required|numeric',
                'expiryDate' => 'required'
            ]);
        } catch (ValidationException $e) {

        }
    }
    public function storeCoupon(){
        $this->validate([
            'code' => 'required|unique:coupons',
            'type' => 'required',
            'value' => 'required|numeric',
            'cartValue' => 'required|numeric',
            'expiryDate' => 'required'
        ]);
        $coupon = new Coupon();
        $coupon->code = $this->code;
        $coupon->type = $this->type;
        $coupon->value = $this->value;
        $coupon->cartValue = $this->cartValue;
        $coupon->expiryDate = $this->expiryDate;
        $coupon->save();
        session()->flash('message','Coupon has been created successfully');
    }
    public function render(){
        return view('livewire.admin.admin-add-coupon-component')->layout('layouts.base');
    }
}
