<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Histo extends Model
{
    use HasFactory;

    protected $with = ['user'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function histoPhotos(){
        return $this->hasMany(HistoPhoto::class);
    }
    public function hospital(){
        return $this->belongsTo(Hospital::class);
    }

}
