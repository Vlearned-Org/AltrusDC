<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'pic_name',
        'training_category',
        'fiscal_year',
        'training_hours',
        'management',
        'executive',
        'non_executive',
        'general_worker',
    ];

    protected static function booted()
    {
        static::saving(function ($model) {
            $model->total_participants = $model->calculateTotalParticipants();
        });
    }

    public function calculateTotalParticipants()
    {
        return ($this->management ?? 0) + 
               ($this->executive ?? 0) + 
               ($this->non_executive ?? 0) + 
               ($this->general_worker ?? 0);
    }

    public function getAttachmentUrlAttribute()
    {
        return $this->attachment ? \Storage::url($this->attachment) : null;
    }

    public function isImageAttachment()
    {
        if (!$this->attachment) return false;
        
        $extension = strtolower(pathinfo($this->attachment, PATHINFO_EXTENSION));
        return in_array($extension, ['jpg', 'jpeg', 'png', 'gif']);
    }
    public function getNameAttribute()
{
    return "{$this->training_category} - {$this->pic_name}";
}
}