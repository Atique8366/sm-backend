<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'customer_id',
        'item_name',
        'item_quantity',
        'order_date',
        'set_price',
        'your_bill',
        'gate_pass_number',
        'profit',
    ];

    public function item()
    {
        return $this->belongsTo(item::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
