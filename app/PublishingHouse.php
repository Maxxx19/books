<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PublishingHouse extends Model
{
    protected $fillable = [
        'name'
    ];

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }
    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
