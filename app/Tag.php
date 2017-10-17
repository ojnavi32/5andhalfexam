<?php

namespace App;

use App\Pet;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name', 'id',
    ];
    
    protected $hidden = [
        'id'  
    ];

    
    public function pets()
    {
        return $this->belongsToMany(Pet::class);
    }
}
