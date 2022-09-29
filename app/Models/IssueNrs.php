<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueNrs extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'media_id',
        'media',
        'numero',
        'year',
        'month',
        'day',
        'week',
        'final_issue'
    ];
}
