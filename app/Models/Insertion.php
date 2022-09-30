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
        'media',
        'issue_nr',
        'type',
        'placement',
        'brand',
        'comment',
        'quantity',
        'fare',
        'invoiced',
        'RCVD',
        'status',
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

    public function invoiceStatus(){
        return $this->belongsTo(InvoiceStatus::class);
    }
}
