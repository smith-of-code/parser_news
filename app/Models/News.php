<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class News extends Model
{
    use HasFactory;
        protected $table='news';

        protected $fillable=[
            'id',
            'name',
            'description',
            'datetime_pub',
            'author',
            'source',
        ];


        public function images(): BelongsToMany
        {
            return $this->belongsToMany(Image::class,'news_image');
        }
}
