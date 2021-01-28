<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nutrition extends Model
{
    use HasFactory;

    protected $table = 'nutritions';

    protected $fillable = [
        'calories',
        'fat',
        'carbs',
        'protein',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    protected $hidden = ['created_at', 'updated_at'];
}
