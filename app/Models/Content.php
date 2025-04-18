<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\category;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'type',
        'file_path',
        'image_path',
        'is_free',
        'transcription',
    ];
    

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }       
}
