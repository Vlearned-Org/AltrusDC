<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessTravel extends Model
{
    use HasFactory;
protected $table = 'business_travels';
    protected $fillable = [
        'pic_name',
        'account',
        'fiscal_year',
        'employee_name',
        'destination',
        'transport_mode',
        'departure_date',
        'return_date',
        'purpose',
        'distance_km'
    ];

    protected $casts = [
        'departure_date' => 'date',
        'return_date' => 'date',
        'distance_km' => 'decimal:2'
    ];

    public const TRANSPORT_AIRCRAFT = 'AIRCRAFT';
    public const TRANSPORT_TRAIN = 'TRAIN';
    public const TRANSPORT_CAR = 'CAR';
    public const TRANSPORT_MOTORCYCLE = 'MOTORCYCLE';
    public const TRANSPORT_BUS = 'BUS';
    public const TRANSPORT_SHIP = 'SHIP';
    public const TRANSPORT_BOAT = 'BOAT';
    public const TRANSPORT_TAXI = 'TAXI';
    public const TRANSPORT_RIDE_HAILING = 'RIDE_HAILING';
    public const TRANSPORT_BICYCLE = 'BICYCLE';
    public const TRANSPORT_WALKING = 'WALKING';
    public const TRANSPORT_OTHER = 'OTHER';

    public static function getTransportModes(): array
    {
        return [
            self::TRANSPORT_AIRCRAFT => 'Aircraft',
            self::TRANSPORT_TRAIN => 'Train',
            self::TRANSPORT_CAR => 'Car',
            self::TRANSPORT_MOTORCYCLE => 'Motorcycle',
            self::TRANSPORT_BUS => 'Bus',
            self::TRANSPORT_SHIP => 'Ship',
            self::TRANSPORT_BOAT => 'Boat',
            self::TRANSPORT_TAXI => 'Taxi',
            self::TRANSPORT_RIDE_HAILING => 'Ride Hailing',
            self::TRANSPORT_BICYCLE => 'Bicycle',
            self::TRANSPORT_WALKING => 'Walking',
            self::TRANSPORT_OTHER => 'Other',
        ];
    }

    public function getDurationAttribute(): ?int
    {
        if (!$this->return_date) {
            return null;
        }
        
        return $this->departure_date->diffInDays($this->return_date);
    }
}