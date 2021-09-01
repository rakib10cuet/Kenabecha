<?php

namespace App\Http\Livewire\Admin;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AdminOrderComponent extends Component{
    use WithPagination;
    public function updateOrdersStatus($orderId,$status){
        $order = Order::find($orderId);
        $order->status = $status;
        if($status == 'delivered'){
            $order->deliveredDate = DB::raw('CURRENT_DATE');
        }elseif ($status == 'cancelled'){
            $order->cancelledDate = DB::raw('CURRENT_DATE');
        }
        $order->save();
        session()->flash('Order_message','Order Status has been updated successfully!');
    }
    public function render(){
        $orders = Order::orderBy('created_at','DESC')->paginate(12);
        return view('livewire.admin.admin-order-component',['orders'=>$orders])->layout('layouts.base');
    }
}
