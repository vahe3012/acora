<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analyzes extends AppModel
{
    use HasFactory;

    protected $fillable = ['title_am', 'title_en', 'attachment_id'];

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }
}
