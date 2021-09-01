<?php
namespace App\Http\Livewire\Admin;
use App\Models\HomeSlider;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminEditHomeSliderComponent extends Component{
    use WithFileUploads;
    public $title;
    public $subTitle;
    public $price;
    public $link;
    public $image;
    public $status;
    public $newimage;
    public $sliderID;
    public function mount($sliderId){
        $slider = HomeSlider::find($sliderId);
        $this->title = $slider->title;
        $this->subTitle = $slider->subTitle;
        $this->price = $slider->price;
        $this->link = $slider->link;
        $this->image = $slider->image;
        $this->status = $slider->status;
        $this->sliderID = $slider->id;
    }
    public function updated($fields){
        try {
            $this->validateOnly($fields, [
                'title' => 'required',
                'subTitle' => 'required',
                'price' => 'required|numeric',
                'link' => 'required',
                'newimage' => 'required|mimes:jpg,png',
                'status' => 'required|numeric',
            ]);
        } catch (ValidationException $e) {
        }
    }
    public function updateSlider(){
        $this->validate([
            'title' => 'required',
            'subTitle' => 'required',
            'price' => 'required|numeric',
            'link' => 'required',
            'newimage' => 'required|mimes:jpg,png',
            'status' => 'required|numeric',
        ]);
        $slider = HomeSlider::find($this->sliderID);
        $slider->title = $this->title;
        $slider->subTitle = $this->subTitle;
        $slider->price = $this->price;
        $slider->link = $this->link;
        if($this->newimage){
            $imageName = Carbon::now()->timestamp.'.'.$this->newimage->extension();
            $this->newimage->storeAs('sliders',$imageName);
            $slider->image = $imageName;
        }
        $slider->status = $this->status;
        $slider->save();
        session()->flash('message','Slide has been updated successfully');
    }

    public function render(){
        return view('livewire.admin.admin-edit-home-slider-component')->layout('layouts.base');
    }
}
