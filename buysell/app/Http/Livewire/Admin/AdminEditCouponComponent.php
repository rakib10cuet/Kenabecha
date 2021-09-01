<?php

namespace App\Http\Livewire\Admin;

use App\Models\Coupon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class AdminEditCouponComponent extends Component{
    public $code;
    public $type;
    public $value;
    public $cartValue;
    public $expiryDate;
    public $couponId;
    public function mount($couponId){
        $this->$couponId = $couponId;
        $coupon = Coupon::find($couponId);
        $this->code = $coupon->code;
        $this->type = $coupon->type;
        $this->value = $coupon->value;
        $this->cartValue = $coupon->cartValue;
        $this->expiryDate = $coupon->expiryDate;
        $this->couponId = $coupon->id;
    }
    public function updated($fields){
        try {
            $this->validateOnly($fields, [
                'code' => 'required',
                'type' => 'required',
                'value' => 'required|numeric',
                'cartValue' => 'required|numeric',
                'expiryDate' => 'required'
            ]);
        } catch (ValidationException $e) {

        }
    }
    public function updateCoupon(){
        $this->validate([
            'code' => 'required',
            'type' => 'required',
            'value' => 'required|numeric',
            'cartValue' => 'required|numeric',
            'expiryDate' => 'required'
        ]);
        $coupon = Coupon::find($this->couponId);
        $coupon->code = $this->code;
        $coupon->type = $this->type;
        $coupon->value = $this->value;
        $coupon->cartValue = $this->cartValue;
        $coupon->expiryDate = $this->expiryDate;
        $coupon->save();
        session()->flash('message','Coupon has been updated successfully');
    }
    public function render(){
        return view('livewire.admin.admin-edit-coupon-component')->layout('layouts.base');
    }
}
