<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = ['first_name', 'last_name', 'title', 'city', 'postcode', 'street_address', 'phone_number', 'email'];

    public function nutrition()
    {
        return $this->hasOne(Nutrition::class);
    }

    protected $hidden = ['created_at'];
}
