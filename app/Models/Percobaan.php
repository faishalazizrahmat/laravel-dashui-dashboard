<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Percobaan extends Model
{
    use HasFactory;

    protected $table = 'percobaan';

    protected $fillable = [
        'jumlah_gerakan',
        'waktu_gerakan',
        'jarak_perpindahan',
        'user_id'
    ];
}
