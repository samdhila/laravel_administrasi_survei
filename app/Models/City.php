<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'population', 'surveyor_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'surveyor_id')->withDefault();
    }
}
