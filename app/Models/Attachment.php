<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_path', 'file_name', 'file_type', 'file_size', 'description'
    ];

    public function attachable()
    {
        return $this->morphTo();
    }
}
