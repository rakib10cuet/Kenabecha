<?php
namespace App\Http\Livewire;
use App\Models\Messages;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
class MessengerComponent extends Component{
    public $allMessages;
    public $message;
    public $sender;
    public function getUser($userId){
        $users = User::find($userId);
        $this->sender = $users;
        $this->allMessages = Messages::where('userId',Auth()->id())->where('receiverId',$userId)->orwhere('userId',$userId)->orwhere('receiverId',Auth()->id())->orderby('id','DESC')->get();
    }
    public function resetForm(){
        $this->message = '';
    }
    public function mountdata(){
        if(!empty($this->sender->id)){
            $this->allMessages = Messages::where('userId',Auth()->id())->where('receiverId',$this->sender->id)->orwhere('userId',$this->sender->id)->orwhere('receiverId',Auth()->id())->orderby('id','DESC')->get();

            $not_seen = Messages::where('userId',$this->sender->id)->where('receiverId',auth()->id())->where('is_seen',false);
            $not_seen->update(['is_seen'=>true]);
        }
    }


    public function SendMessage(){
        if(!empty($this->sender->id)){
            $Messages = new Messages();
            $Messages->message = $this->message;
            $Messages->userId = Auth()->id();
            $Messages->receiverId = $this->sender->id;
            $Messages->save();
            $this->resetForm();
        }else{
            session()->flash('message','Select your Friend');
        }
    }

    public function render(){
        $onlineUsers = DB::table('users')->where('id','<>',auth()->id())->get();     /*subscribes friend sudu thakbe*/
        $sender = $this->sender;
        $this->allMessages;
        return view('livewire.messenger-component',['onlineUsers'=>$onlineUsers,'sender'=>$sender])->layout('layouts.base');
    }
}
