<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinUs extends Model
{
    use HasFactory;

    protected $table = 'joinus';

     protected $fillable = [
        'name',
        'email',
    ];
}
