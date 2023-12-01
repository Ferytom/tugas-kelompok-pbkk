<?php

namespace App\Modules\Shared\Core\Domain\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'waktu',
        'keterangan',
        'hargaTotal',
        'statusTransaksi',
        'noMeja',
        'isReservasi',
        'promo_id',
        'user_id',
        'location_id',
    ];

    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
