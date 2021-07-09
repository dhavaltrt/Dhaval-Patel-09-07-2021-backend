<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use App\User;

class Message extends Model
{
    use SoftDeletes;

    // allow all fileds to be fillable
    protected $guarded = [];

    protected $appends = ['deleted_array_id'];
    
    protected $with = ['sender', 'receiver'];

    public function getDeletedArrayIdAttribute() {        
        return ($this->deleted_by) ? json_decode($this->deleted_by): [];
    }

    public function sender() {        
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function receiver() {        
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }
}
