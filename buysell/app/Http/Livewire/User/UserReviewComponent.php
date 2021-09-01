<?php

namespace App\Http\Livewire\User;

use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class UserReviewComponent extends Component
{
    public $orderItemId;
    public $rating;
    public $comment;
    public function mount($orderItemId){
        $this->orderItemId = $orderItemId;
    }
    public function updated($fields){
        try {
            $this->validateOnly($fields, [
                'rating' => 'required',
                'comment' => 'required'
            ]);
        } catch (ValidationException $e) {
        }
    }
    public function addReview(){
        $this->validate([
            'rating' => 'required',
            'comment' => 'required'
        ]);
        $review = new Review();
        $review->rating = $this->rating;
        $review->comment = $this->comment;
        $review->orderItemId = $this->orderItemId;
        $review->save();
        $orderItem = OrderItem::find($this->orderItemId);
        $orderItem->rstatus = true;
        $orderItem->save();
        session()->flash('message','Your review has been added successfully!!');
    }
    public function render(){
        $orderItem = OrderItem::find($this->orderItemId);
        return view('livewire.user.user-review-component',['orderItem'=>$orderItem])->layout('layouts.base');
    }
}
