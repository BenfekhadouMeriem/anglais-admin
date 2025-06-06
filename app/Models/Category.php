<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Content;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];

    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}
