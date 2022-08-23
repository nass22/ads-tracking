<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insertion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'job_id',
        'company',
        'brand',
        'comment',
        'media',
        'type',
        'placement',
        'month',
        'issue_nr',
        'number_of_pages',
        'quantity',
        'fare',
        'invoiced',
        'year',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function media(){
        return $this->belongsTo(Media::class);
    }
}
