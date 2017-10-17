<?php

namespace App;

use App\Tag;
use App\Category;
use App\Order;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'categoryId', 'tagId', 'name', 'photoUrls', 'status'
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    
    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
