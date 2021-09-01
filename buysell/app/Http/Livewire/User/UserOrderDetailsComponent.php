<?php

namespace App\Http\Livewire\User;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UserOrderDetailsComponent extends Component
{
    public $orderId;
    public function mount($orderId){
        $this->orderId = $orderId;
    }
    public function cancelOrder(){
        $order = Order::find($this->orderId);
        $order->status = 'cancelled';
        $order->cancelledDate = DB::raw('CURRENT_DATE');
        $order->save();
        session()->flash('Order_message','Order has been cancelled!');
    }
    public function render(){
        $order = Order::where('userId',Auth::user()->id)->where('id',$this->orderId)->first();
        return view('livewire.user.user-order-details-component',['order'=>$order])->layout('layouts.base');
    }
}
