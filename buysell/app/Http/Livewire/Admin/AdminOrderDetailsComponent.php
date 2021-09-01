<?php
namespace App\Http\Livewire\Admin;
use App\Models\Order;
use Livewire\Component;

class AdminOrderDetailsComponent extends Component{
    public $orderId;
    public function mount($orderId){
        $this->orderId = $orderId;
    }
    public function render(){
        $order = Order::find($this->orderId);
        return view('livewire.admin.admin-order-details-component',['order'=>$order])->layout('layouts.base');
    }
}
