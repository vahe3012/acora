<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Law extends AppModel
{
    use HasFactory;

    protected $guarded = [];

    const TYPE_LAW = 'law';
    const TYPE_REGULATION = 'regulation';

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'id', 'attachment_id');
    }
}
