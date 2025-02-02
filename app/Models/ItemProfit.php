<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemProfit extends Model
{
    use HasFactory;
    protected $table = 'item_profits';
    protected $primaryKey = 'item_id';
    public $incrementing = false; // Since ItemId is primary key, but not auto-incrementing
    protected $fillable = ['item_id', 'profit'];
    public $timestamps = false;

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
