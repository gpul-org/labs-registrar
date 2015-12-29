<?php

namespace Registration;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    protected $fillable = ['user_id', 'pending', 'accepted'];

    protected $hidden = ['github_token'];

    public function user()
    {
        return $this->belongsTo('Registration\User');
    }
}
