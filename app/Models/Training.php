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
        'total_participants',
        'management_hours',
        'executive_hours',
        'non_executive_hours',
        'general_worker_hours',
        'total_training_hours',
    ];

    protected static function booted()
    {
        static::saving(function ($model) {
            $model->calculateAllFields();
        });
    }

    public function calculateAllFields()
    {
        $this->total_participants = $this->calculateTotalParticipants();
        $this->management_hours = $this->calculateCategoryHours('management');
        $this->executive_hours = $this->calculateCategoryHours('executive');
        $this->non_executive_hours = $this->calculateCategoryHours('non_executive');
        $this->general_worker_hours = $this->calculateCategoryHours('general_worker');
        $this->total_training_hours = $this->calculateTotalTrainingHours();
    }

    public function calculateTotalParticipants()
    {
        return ($this->management ?? 0) + 
               ($this->executive ?? 0) + 
               ($this->non_executive ?? 0) + 
               ($this->general_worker ?? 0);
    }

    public function calculateCategoryHours($category)
    {
        return ($this->$category ?? 0) * ($this->training_hours ?? 0);
    }

    public function calculateTotalTrainingHours()
    {
        return $this->management_hours + 
               $this->executive_hours + 
               $this->non_executive_hours + 
               $this->general_worker_hours;
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