<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\TransactionBeginning;

class Promo extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'detail',
        'persenDiskon',
        'maxDiskon',
        'expired',
    ];

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

}
