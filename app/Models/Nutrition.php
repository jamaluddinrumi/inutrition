<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nutrition extends Model
{
    use HasFactory;

    protected $table = 'Nutrition';

    public function customer() {
        return $this->belongsTo(Customer::class);
    }
}
