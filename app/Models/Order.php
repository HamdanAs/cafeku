<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    const EATING = 1;
    const DONE = 2;

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function transactionDate(): Attribute
    {
        return Attribute::make(
            fn ($value) => Carbon::createFromFormat('d', $value)->format('d'),
            fn ($value) => Carbon::createFromFormat('d', $value)->format('d')
        );
    }
}
