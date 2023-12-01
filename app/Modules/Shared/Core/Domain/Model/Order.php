<?php

namespace App\Modules\Shared\Core\Domain\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'quantity',
        'transaction_id',
        'menu_id',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
