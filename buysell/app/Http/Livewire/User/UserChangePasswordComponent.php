<?php

namespace App\Http\Livewire\User;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class UserChangePasswordComponent extends Component{
    public $currentPassword;
    public $password;
    public $password_confirmation ;
    public function updated($fields){
        try {
            $this->validateOnly($fields, [
                'currentPassword' => 'required',
                'password' => 'required|min:8|confirmed|different:currentPassword',
            ]);
        } catch (ValidationException $e) {
        }
    }
    public function changePassword(){
        $this->validate([
            'currentPassword' => 'required',
            'password' => 'required|min:8|confirmed|different:currentPassword',
        ]);
        $userData = Auth::user();
        if(Hash::check($this->currentPassword,$userData->password)){
            $user = User::findOrFail($userData->id);
            $user->password = Hash::make($this->password);
            $user->save();
            session()->flash('password_success','Password has been changed successfully!!');
        }else{
            session()->flash('password_error','Password does not match!!!');
        }


    }
    public function render(){
        return view('livewire.user.user-change-password-component')->layout('layouts.base');
    }
}
