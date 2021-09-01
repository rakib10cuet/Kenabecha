<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;
    protected $table = 'messages';
    protected $fillable = ['message', 'userId', 'receiverId', 'is_seen'];
    /**
     * @var mixed
     */
    public function user(){
        return $this->belongsTo(User::class,'userId');
    }
}
