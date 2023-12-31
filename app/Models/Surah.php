<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surah extends Model
{
    use HasFactory;

    protected $table = 'surah';

    protected $fillable = [
        'juz_id',
        'name_en',
        'name_ar',
        'text'
    ];

    public function ayat()
    {
        return $this->hasMany(Ayah::class);
    }

    public function surah()
    {
        return $this->BelongsTo(Surah::class,'surah_id','id');
    }
}
