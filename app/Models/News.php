<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends AppModel
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['mainImage', 'categories'];

    const STATUS_MAIN = 1;

    const LIST_LIMIT = 5;

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'news_categories');
    }

    public function mainImage(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Attachment::class, 'id', 'main_image');
    }
}
