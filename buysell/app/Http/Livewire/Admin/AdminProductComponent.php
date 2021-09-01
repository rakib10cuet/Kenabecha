<?php
namespace App\Http\Livewire\Admin;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;


class AdminProductComponent extends Component{
    use WithPagination;

    public $autoIncrement = 1;
    public function deleteProduct($id){
        $product = Product::find($id);
        $product->delete();
        session()->flash('message','Product has been Deleted successfully');
    }

    public function render(){
        $product = Product::orderBy('id', 'DESC')->paginate(10);
        return view('livewire.admin.admin-product-component',['products'=>$product])->layout('layouts.base');
    }
}
