<?php
namespace App\Http\Livewire\Admin;
use App\Models\Coupon;
use Livewire\Component;
class AdminCouponComponent extends Component{
    public function deleteCoupon($couponId){
        $category = Coupon::find($couponId);
        $category->delete();
        session()->flash('message','Coupon has been deleted successfully');
    }
    public function render(){
        $coupons = Coupon::all();
        return view('livewire.admin.admin-coupon-component',['coupons'=> $coupons])->layout('layouts.base');
    }
}
