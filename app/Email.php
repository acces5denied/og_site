<?php

namespace App;

use App\Repositories\DateFormat;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [
        'subject', 'name', 'phone', 'email', 'text', 'status'
    ];
    
    public function getCreatedAtAttribute($attr)
    {
        return DateFormat::post($attr);
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
