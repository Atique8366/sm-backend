<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockWithDate extends Model
{
    use HasFactory;
    protected $table = 'stock_with_dates';
    protected $fillable = ['date_from', 'date_to'];
    public $timestamps = false;
}
