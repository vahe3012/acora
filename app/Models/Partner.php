<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Partner extends AppModel
{
    use HasFactory;

    protected $guarded = [];

    public function image(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Attachment::class, 'id', 'image_id');
    }
}
