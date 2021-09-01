<?php

namespace App\Http\Livewire\Admin;

use App\Models\HomeSlider;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminAddHomeSliderComponent extends Component{
    use WithFileUploads;
    public $title;
    public $subTitle;
    public $price;
    public $link;
    public $image;
    public $status;
    public function mount(){
        $this->status = 0;
    }

    public function updated($fields){
        try {
            $this->validateOnly($fields, [
                'title' => 'required',
                'subTitle' => 'required',
                'price' => 'required|numeric',
                'link' => 'required',
                'image' => 'required|mimes:jpg,png',
                'status' => 'required|numeric',
            ]);
        } catch (ValidationException $e) {
        }
    }
    public function addSlide(){
        $this->validate([
            'title' => 'required',
            'subTitle' => 'required',
            'price' => 'required|numeric',
            'link' => 'required',
            'image' => 'required|mimes:jpg,png',
            'status' => 'required|numeric',
        ]);
        $slider = new HomeSlider();
        $slider->title = $this->title;
        $slider->subTitle = $this->subTitle;
        $slider->price = $this->price;
        $slider->link = $this->link;
        $imageName = Carbon::now()->timestamp.'.'.$this->image->extension();
        $this->image->storeAs('sliders',$imageName);
        $slider->image = $imageName;
        $slider->status = $this->status;
        $slider->save();
        session()->flash('message','Slide has been created successfully');
    }

    public function render(){
        return view('livewire.admin.admin-add-home-slider-component')->layout('layouts.base');
    }
}
