<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    protected $fillable = [
        'name'
    ];

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }
    public function publishingHouses()
    {
        return $this->belongsToMany(PublishingHouse::class);
    }
}
