<?php

namespace App\Http\Livewire\Admin;

use App\Models\Setting;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class AdminSettingComponent extends Component
{
    public $image;
    public $email;
    public $phone;
    public $phone2;
    public $address;
    public $map;
    public $twitter;
    public $facebook;
    public $pinterest;
    public $instagram;
    public $youtube;
    public function mount(){
        $setting = Setting::find(1);
        if (!empty($setting)){
            $this->images = $setting->images;
            $this->email = $setting->email;
            $this->phone = $setting->phone;
            $this->phone2 = $setting->phone2;
            $this->address = $setting->address;
            $this->map = $setting->map;
            $this->twitter = $setting->twitter;
            $this->facebook = $setting->facebook;
            $this->pinterest = $setting->pinterest;
            $this->instagram = $setting->instagram;
            $this->youtube = $setting->youtube;
        }
    }
    public function updated($fields){
        try {
            $this->validateOnly($fields, [
                'image' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'phone2' => 'required',
                'address' => 'required',
                'map' => 'required',
                'twitter' => 'required',
                'facebook' => 'required',
                'pinterest' => 'required',
                'instagram' => 'required',
                'youtube' => 'required'
            ]);
        } catch (ValidationException $e) {
        }
    }
    public function saveSettings(){

        $this->validate([
            'image' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'phone2' => 'required',
            'address' => 'required',
            'map' => 'required',
            'twitter' => 'required',
            'facebook' => 'required',
            'pinterest' => 'required',
            'instagram' => 'required',
            'youtube' => 'required'
        ]);
        $setting = Setting::find(1);
        if(empty($setting)){
            $setting = new Setting();
        }
        $setting->image = $this->image;
        $setting->email = $this->email;
        $setting->phone = $this->phone;
        $setting->phone2 = $this->phone2;
        $setting->address = $this->address;
        $setting->map = $this->map;
        $setting->twitter = $this->twitter;
        $setting->facebook = $this->facebook;
        $setting->pinterest = $this->pinterest;
        $setting->instagram = $this->instagram;
        $setting->youtube = $this->youtube;
        $setting->save();
        session()->flash('message','Setting has been saved successfully!!');
    }

    public function render(){
        return view('livewire.admin.admin-setting-component')->layout('layouts.base');
    }
}
