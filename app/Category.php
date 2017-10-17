<?php

namespace App;

use App\Pet;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'id',
    ];
    
    protected $hidden = [
        'id'  
    ];
    
    public function pets()
    {
        return $this->hasMany(Pet::class);
    }
}
