<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = ['from', 'until', 'days', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
