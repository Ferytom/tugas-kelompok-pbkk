<?php

namespace App\Modules\Shared\Core\Domain\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $fillable = [
        'namaLokasi',
        'alamat',
        'googleMap'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function waitlist()
    {
        return $this->hasMany(Waitlist::class);
    }
}
