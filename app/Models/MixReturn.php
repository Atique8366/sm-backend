<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MixReturn extends Model
{
    use HasFactory;
    protected $table = 'mix_returns';
    protected $fillable = ['total_sale', 'total_profit'];
    public $timestamps = false;

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
