<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surah extends Model
{
    use HasFactory;

    protected $table = 'surah';

    protected $fillable = [
        'name_en',
        'name_ar'
    ];

    public function ayat()
    {
        return $this->hasMany(Ayah::class);
    }
}