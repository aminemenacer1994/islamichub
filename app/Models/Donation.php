<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $table = 'donation';


    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'payment_status',
        'currency',
        'amount',
        'country',
       
    ];
}
