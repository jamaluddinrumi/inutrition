<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    public function nutrition()
    {
        return $this->hasOne(Nutrition::class);
    }

    protected $hidden = ['created_at', 'updated_at'];
}
