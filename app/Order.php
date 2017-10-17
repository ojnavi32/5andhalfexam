<?php

namespace App;

use App\Pet;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'petId', 'quantity', 'shipDate',
        'status', 'complete'
    ];
    
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'petId');
    }
}
