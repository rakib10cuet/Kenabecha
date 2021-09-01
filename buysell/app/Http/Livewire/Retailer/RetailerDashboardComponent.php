<?php

namespace App\Http\Livewire\Retailer;

use Livewire\Component;

class RetailerDashboardComponent extends Component
{
    public function render()
    {
        return view('livewire.retailer.retailer-dashboard-component')->layout('layouts.base');
    }
}
