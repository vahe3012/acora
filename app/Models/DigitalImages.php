<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class DigitalImages extends AppModel
{
    use HasFactory;

    protected $fillable = ['attachment_id', 'title_am', 'title_en', 'order'];

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }
}
