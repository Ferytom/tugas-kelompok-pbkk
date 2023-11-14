<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'pathFoto',
    ];

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}