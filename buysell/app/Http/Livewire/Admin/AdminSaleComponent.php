<?php

namespace App\Http\Livewire\Admin;

use App\Models\Sale;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class AdminSaleComponent extends Component
{
    public $saleDate;
    public $status;
    public function mount(){
        $sale = Sale::find(1);
        if(!empty($sale)){
            $this->saleDate = $sale->saleDate;
            $this->status = $sale->status;
        }
    }
    public function updated($fields){
        try {
            $this->validateOnly($fields, [
                'saleDate' => 'required',
                'status' => 'required|numeric',
            ]);
        } catch (ValidationException $e) {
        }
    }
    public function updateSale(){
        $this->validate([
            'saleDate' => 'required',
            'status' => 'required|numeric',
        ]);
        $sale = Sale::find(1);

        if(!empty($sale)){
            $sale->saleDate = $this->saleDate;
            $sale->status = $this->status;
        }else{
            $sale = new Sale();
            $sale->saleDate = $this->saleDate;
            $sale->status = $this->status;
        }
        $sale->save();
        session()->flash('message','Record has been updated successfully');
    }

    public function render()
    {
        return view('livewire.admin.admin-sale-component')->layout('layouts.base');
    }
}
