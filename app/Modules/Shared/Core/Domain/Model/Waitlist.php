<?php

namespace App\Modules\Shared\Core\Domain\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waitlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jumlahOrang',
        'location_id'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
