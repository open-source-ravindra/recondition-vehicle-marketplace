<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleTransfer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transfer_number',
        'vehicle_id',
        'buyer_id',
        'seller_id',
        'witness_id',
        'buyer_spouse_id',
        'created_by',
        'notes',
        'expenses_borne_by_buyer',
        'transfer_date',
        'status',
        'registration_fee',
        'tax_amount',
        'commission',
        'other_expenses',
        'total_expenses',
        'bluebook_received',
        'insurance_transferred',
        'key_handover',
        'documents_handover',
    ];

    protected $casts = [
        'transfer_date' => 'date',
        'expenses_borne_by_buyer' => 'boolean',
        'bluebook_received' => 'boolean',
        'insurance_transferred' => 'boolean',
        'key_handover' => 'boolean',
        'documents_handover' => 'boolean',
        'registration_fee' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'commission' => 'decimal:2',
        'other_expenses' => 'decimal:2',
        'total_expenses' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Transfer statuses
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_IN_PROGRESS = 'in_progress';

    // Generate transfer number
    public static function generateTransferNumber()
    {
        $date = date('Ymd');
        $lastTransfer = self::where('transfer_number', 'like', "TRF-{$date}-%")
            ->orderBy('transfer_number', 'desc')
            ->first();

        if ($lastTransfer) {
            $lastNumber = intval(substr($lastTransfer->transfer_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return "TRF-{$date}-{$newNumber}";
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->transfer_number)) {
                $model->transfer_number = self::generateTransferNumber();
            }
        });
    }

    // Accessors
    public function getStatusTextAttribute()
    {
        $statuses = [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_IN_PROGRESS => 'In Progress',
        ];
        return $statuses[$this->status] ?? $this->status;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            self::STATUS_PENDING => 'warning',
            self::STATUS_COMPLETED => 'success',
            self::STATUS_CANCELLED => 'danger',
            self::STATUS_IN_PROGRESS => 'info',
        ];
        return $badges[$this->status] ?? 'secondary';
    }

    public function getTotalAmountAttribute()
    {
        return $this->payment ? $this->payment->total_price : 0;
    }

    public function getAmountPaidAttribute()
    {
        return $this->payment ? $this->payment->amount_paid : 0;
    }

    public function getAmountDueAttribute()
    {
        return $this->total_amount - $this->amount_paid;
    }

    public function getIsFullyPaidAttribute()
    {
        return $this->amount_due <= 0;
    }

    public function getFormattedTransferDateAttribute()
    {
        return $this->transfer_date->format('d M, Y');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('transfer_date', '>=', now()->subDays($days));
    }

    public function scopeByDateRange($query, $from, $to)
    {
        return $query->whereBetween('transfer_date', [$from, $to]);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('transfer_number', 'like', "%{$search}%")
            ->orWhereHas('vehicle', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('engine_number', 'like', "%{$search}%")
                    ->orWhere('chassis_number', 'like', "%{$search}%");
            })
            ->orWhereHas('buyer', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('citizenship_number', 'like', "%{$search}%");
            })
            ->orWhereHas('seller', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('citizenship_number', 'like', "%{$search}%");
            });
    }

    // Relationships
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function buyer()
    {
        return $this->belongsTo(Customer::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(Customer::class, 'seller_id');
    }

    public function witness()
    {
        return $this->belongsTo(Customer::class, 'witness_id');
    }

    public function buyerSpouse()
    {
        return $this->belongsTo(Customer::class, 'buyer_spouse_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'transfer_id');
    }

    public function documents()
    {
        return $this->hasMany(TransferDocument::class);
    }

    // Business logic methods
    public function markAsCompleted()
    {
        $this->update(['status' => self::STATUS_COMPLETED]);
        if ($this->vehicle) {
            $this->vehicle->update(['status' => Vehicle::STATUS_SOLD]);
        }
    }

    public function markAsCancelled()
    {
        $this->update(['status' => self::STATUS_CANCELLED]);
        if ($this->vehicle) {
            $this->vehicle->update(['status' => Vehicle::STATUS_AVAILABLE]);
        }
    }

    public function calculateTotalExpenses()
    {
        return ($this->registration_fee ?? 0) +
            ($this->tax_amount ?? 0) +
            ($this->commission ?? 0) +
            ($this->other_expenses ?? 0);
    }

    public function updateTotalExpenses()
    {
        $this->total_expenses = $this->calculateTotalExpenses();
        $this->save();
    }
}
