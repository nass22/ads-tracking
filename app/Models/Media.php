<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'abbreviation',
        'type',
        'placement',
    ];

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function medias(){
        return $this->hasMany(Media::class);
    }
}
