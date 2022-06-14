<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends AppModel
{
    use HasFactory;

    protected $fillable = ['title_am', 'title_en', 'description_am', 'description_en', 'attachment_id'];

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }
}
