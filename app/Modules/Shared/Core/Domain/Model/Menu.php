<?php

namespace App\Modules\Shared\Core\Domain\Model;

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
