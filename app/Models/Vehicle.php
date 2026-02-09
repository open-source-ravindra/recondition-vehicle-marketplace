<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'vehicle_type',
        'cc',
        'manufacture_year',
        'condition',
        'color',
        'engine_number',
        'chassis_number',
        'purchase_price',
        'selling_price',
        'registered_name',
        'transferred_by',
        'purchase_date',
        'status',
        'description',
        'images',
        'mileage',
        'fuel_type',
        'transmission',
        'owner_count',
        'insurance_valid_until',
        'tax_paid_until',
        'bluebook_copy',
        'insurance_copy',
        'remarks',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'insurance_valid_until' => 'date',
        'tax_paid_until' => 'date',
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'images' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Vehicle types
    const TYPE_BIKE = 'bike';
    const TYPE_CAR = 'car';
    const TYPE_SCOOTER = 'scooter';
    const TYPE_OTHER = 'other';

    // Vehicle conditions
    const CONDITION_NEW = 'new';
    const CONDITION_USED = 'used';
    const CONDITION_EXCELLENT = 'excellent';
    const CONDITION_GOOD = 'good';
    const CONDITION_FAIR = 'fair';

    // Vehicle statuses
    const STATUS_AVAILABLE = 'available';
    const STATUS_SOLD = 'sold';
    const STATUS_UNDER_MAINTENANCE = 'under_maintenance';
    const STATUS_RESERVED = 'reserved';

    // Fuel types
    const FUEL_PETROL = 'petrol';
    const FUEL_DIESEL = 'diesel';
    const FUEL_ELECTRIC = 'electric';
    const FUEL_HYBRID = 'hybrid';

    // Transmission types
    const TRANSMISSION_MANUAL = 'manual';
    const TRANSMISSION_AUTOMATIC = 'automatic';

    // Accessors
    public function getDisplayNameAttribute()
    {
        return $this->name . ' (' . $this->cc . 'cc, ' . $this->manufacture_year . ')';
    }

    public function getConditionTextAttribute()
    {
        return ucfirst($this->condition);
    }

    public function getStatusTextAttribute()
    {
        $statuses = [
            self::STATUS_AVAILABLE => 'Available',
            self::STATUS_SOLD => 'Sold',
            self::STATUS_UNDER_MAINTENANCE => 'Under Maintenance',
            self::STATUS_RESERVED => 'Reserved',
        ];
        return $statuses[$this->status] ?? $this->status;
    }

    public function getVehicleTypeTextAttribute()
    {
        $types = [
            self::TYPE_BIKE => 'Bike',
            self::TYPE_CAR => 'Car',
            self::TYPE_SCOOTER => 'Scooter',
            self::TYPE_OTHER => 'Other',
        ];
        return $types[$this->vehicle_type] ?? $this->vehicle_type;
    }

    public function getProfitAttribute()
    {
        if ($this->selling_price && $this->purchase_price) {
            return $this->selling_price - $this->purchase_price;
        }
        return 0;
    }

    public function getProfitPercentageAttribute()
    {
        if ($this->purchase_price > 0) {
            return ($this->profit / $this->purchase_price) * 100;
        }
        return 0;
    }

    public function getAgeAttribute()
    {
        return date('Y') - $this->manufacture_year;
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', self::STATUS_AVAILABLE);
    }

    public function scopeSold($query)
    {
        return $query->where('status', self::STATUS_SOLD);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('vehicle_type', $type);
    }

    public function scopeBikes($query)
    {
        return $query->where('vehicle_type', self::TYPE_BIKE);
    }

    public function scopeCars($query)
    {
        return $query->where('vehicle_type', self::TYPE_CAR);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('engine_number', 'like', "%{$search}%")
            ->orWhere('chassis_number', 'like', "%{$search}%")
            ->orWhere('registered_name', 'like', "%{$search}%");
    }

    public function scopePriceRange($query, $min, $max)
    {
        return $query->whereBetween('selling_price', [$min, $max]);
    }

    // Relationships
    public function transfers()
    {
        return $this->hasMany(VehicleTransfer::class);
    }

    public function latestTransfer()
    {
        return $this->hasOne(VehicleTransfer::class)->latest();
    }

    public function currentOwner()
    {
        return $this->hasOneThrough(
            Customer::class,
            VehicleTransfer::class,
            'vehicle_id', // Foreign key on VehicleTransfer table
            'id', // Foreign key on Customer table
            'id', // Local key on Vehicle table
            'seller_id' // Local key on VehicleTransfer table
        )->latest();
    }

    // Check if vehicle has images
    public function hasImages()
    {
        return !empty($this->images) && is_array(json_decode($this->images, true));
    }

    // Get first image
    public function getFirstImageAttribute()
    {
        if ($this->hasImages()) {
            $images = json_decode($this->images, true);
            return $images[0] ?? null;
        }
        return null;
    }

    // Get all images as array
    public function getImagesArrayAttribute()
    {
        if ($this->hasImages()) {
            return json_decode($this->images, true);
        }
        return [];
    }
}