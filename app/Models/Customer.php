<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'date_of_birth',
        'citizenship_number',
        'father_name',
        'grandfather_name',
        'phone',
        'ward_no',
        'municipality_type',
        'address',
        'customer_type',
        'email',
        'occupation',
        'additional_phone',
        'permanent_address',
        'temporary_address',
        'photo',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Customer types
    const TYPE_BUYER = 'buyer';
    const TYPE_SELLER = 'seller';
    const TYPE_WITNESS = 'witness';

    // Municipality types
    const MUNICIPALITY_METROPOLITAN = 'metropolitan_city';
    const MUNICIPALITY_SUB_METROPOLITAN = 'sub_metropolitan_city';
    const MUNICIPALITY_MUNICIPALITY = 'municipality';
    const MUNICIPALITY_RURAL = 'rural_municipality';

    // Accessor for formatted phone
    public function getFormattedPhoneAttribute()
    {
        $phone = $this->phone;
        if (strlen($phone) == 10) {
            return substr($phone, 0, 3) . '-' . substr($phone, 3, 3) . '-' . substr($phone, 6);
        }
        return $phone;
    }

    // Accessor for age
    public function getAgeAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    // Scope for buyers
    public function scopeBuyers($query)
    {
        return $query->where('customer_type', self::TYPE_BUYER);
    }

    // Scope for sellers
    public function scopeSellers($query)
    {
        return $query->where('customer_type', self::TYPE_SELLER);
    }

    // Scope for witnesses
    public function scopeWitnesses($query)
    {
        return $query->where('customer_type', self::TYPE_WITNESS);
    }

    // Relationships
    public function boughtTransfers()
    {
        return $this->hasMany(VehicleTransfer::class, 'buyer_id');
    }

    public function soldTransfers()
    {
        return $this->hasMany(VehicleTransfer::class, 'seller_id');
    }

    public function witnessedTransfers()
    {
        return $this->hasMany(VehicleTransfer::class, 'witness_id');
    }

    public function spouseTransfers()
    {
        return $this->hasMany(VehicleTransfer::class, 'buyer_spouse_id');
    }

    // Get all transfers associated with customer
    public function allTransfers()
    {
        return VehicleTransfer::where(function ($query) {
            $query->where('buyer_id', $this->id)
                ->orWhere('seller_id', $this->id)
                ->orWhere('witness_id', $this->id)
                ->orWhere('buyer_spouse_id', $this->id);
        });
    }

    // Total vehicles bought
    public function getTotalBoughtAttribute()
    {
        return $this->boughtTransfers()->count();
    }

    // Total vehicles sold
    public function getTotalSoldAttribute()
    {
        return $this->soldTransfers()->count();
    }

    // Total transaction amount (as buyer)
    public function getTotalPurchaseAmountAttribute()
    {
        return $this->boughtTransfers()->join('payments', 'vehicle_transfers.id', '=', 'payments.transfer_id')
            ->sum('payments.total_price');
    }

    // Total sales amount (as seller)
    public function getTotalSalesAmountAttribute()
    {
        return $this->soldTransfers()->join('payments', 'vehicle_transfers.id', '=', 'payments.transfer_id')
            ->sum('payments.total_price');
    }
}
