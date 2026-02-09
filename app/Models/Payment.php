<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transfer_id',
        'total_price',
        'amount_paid',
        'amount_received',
        'payment_method',
        'transaction_id',
        'payment_notes',
        'payment_date',
        'received_by',
        'payment_type',
        'bank_name',
        'cheque_number',
        'cheque_date',
        'online_transaction_id',
        'payment_status',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'amount_received' => 'decimal:2',
        'payment_date' => 'date',
        'cheque_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Payment methods
    const METHOD_CASH = 'cash';
    const METHOD_CHEQUE = 'cheque';
    const METHOD_BANK_TRANSFER = 'bank_transfer';
    const METHOD_ONLINE = 'online';
    const METHOD_OTHER = 'other';

    // Payment types
    const TYPE_FULL = 'full';
    const TYPE_ADVANCE = 'advance';
    const TYPE_INSTALLMENT = 'installment';
    const TYPE_BALANCE = 'balance';

    // Payment status
    const STATUS_PAID = 'paid';
    const STATUS_PARTIAL = 'partial';
    const STATUS_PENDING = 'pending';
    const STATUS_FAILED = 'failed';

    // Accessors
    public function getRemainingToPayAttribute()
    {
        return max(0, $this->total_price - $this->amount_paid);
    }

    public function getRemainingToReceiveAttribute()
    {
        return max(0, $this->total_price - $this->amount_received);
    }

    public function getPaymentPercentageAttribute()
    {
        if ($this->total_price > 0) {
            return ($this->amount_paid / $this->total_price) * 100;
        }
        return 0;
    }

    public function getIsFullyPaidAttribute()
    {
        return $this->remaining_to_pay <= 0;
    }

    public function getPaymentMethodTextAttribute()
    {
        $methods = [
            self::METHOD_CASH => 'Cash',
            self::METHOD_CHEQUE => 'Cheque',
            self::METHOD_BANK_TRANSFER => 'Bank Transfer',
            self::METHOD_ONLINE => 'Online Payment',
            self::METHOD_OTHER => 'Other',
        ];
        return $methods[$this->payment_method] ?? $this->payment_method;
    }

    public function getPaymentTypeTextAttribute()
    {
        $types = [
            self::TYPE_FULL => 'Full Payment',
            self::TYPE_ADVANCE => 'Advance',
            self::TYPE_INSTALLMENT => 'Installment',
            self::TYPE_BALANCE => 'Balance',
        ];
        return $types[$this->payment_type] ?? $this->payment_type;
    }

    public function getPaymentStatusTextAttribute()
    {
        $statuses = [
            self::STATUS_PAID => 'Paid',
            self::STATUS_PARTIAL => 'Partial',
            self::STATUS_PENDING => 'Pending',
            self::STATUS_FAILED => 'Failed',
        ];
        return $statuses[$this->payment_status] ?? $this->payment_status;
    }

    public function getFormattedPaymentDateAttribute()
    {
        return $this->payment_date->format('d M, Y');
    }

    // Scopes
    public function scopeCashPayments($query)
    {
        return $query->where('payment_method', self::METHOD_CASH);
    }

    public function scopeChequePayments($query)
    {
        return $query->where('payment_method', self::METHOD_CHEQUE);
    }

    public function scopeOnlinePayments($query)
    {
        return $query->where('payment_method', self::METHOD_ONLINE);
    }

    public function scopeFullPayments($query)
    {
        return $query->where('payment_type', self::TYPE_FULL);
    }

    public function scopeByDateRange($query, $from, $to)
    {
        return $query->whereBetween('payment_date', [$from, $to]);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('payment_date', '>=', now()->subDays($days));
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', self::STATUS_PENDING)
            ->orWhere('payment_status', self::STATUS_PARTIAL);
    }

    public function scopeCompleted($query)
    {
        return $query->where('payment_status', self::STATUS_PAID);
    }

    // Relationships
    public function transfer()
    {
        return $this->belongsTo(VehicleTransfer::class, 'transfer_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    // Business logic methods
    public function addPayment($amount, $method = self::METHOD_CASH, $type = self::TYPE_INSTALLMENT, $notes = null)
    {
        $this->amount_paid += $amount;
        $this->amount_received += $amount;

        if ($this->amount_paid >= $this->total_price) {
            $this->payment_status = self::STATUS_PAID;
            // Update transfer status
            if ($this->transfer) {
                $this->transfer->markAsCompleted();
            }
        } else {
            $this->payment_status = self::STATUS_PARTIAL;
        }

        $this->payment_method = $method;
        $this->payment_type = $type;
        $this->payment_notes = $notes;
        $this->save();

        // Create payment history
        PaymentHistory::create([
            'payment_id' => $this->id,
            'amount' => $amount,
            'payment_method' => $method,
            'payment_type' => $type,
            'notes' => $notes,
            'received_by' => auth()->id(),
        ]);

        return $this;
    }

    public function getPaymentHistory()
    {
        return PaymentHistory::where('payment_id', $this->id)->get();
    }
}
