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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactionMonth(): Attribute
    {
        return Attribute::make(
            fn ($value, $attributes) => Carbon::parse($attributes['date'])->format('F'),
        );
    }

    public function transactionMonthCode(): Attribute
    {
        return Attribute::make(
            fn ($value, $attributes) => Carbon::parse($attributes['date'])->month,
        );
    }

    public function transactionYear(): Attribute
    {
        return Attribute::make(
            fn ($value, $attributes) => Carbon::parse($attributes['date'])->format('Y'),
        );
    }
}
