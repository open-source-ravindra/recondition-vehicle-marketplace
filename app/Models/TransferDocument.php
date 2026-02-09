<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'transfer_id',
        'document_type',
        'document_name',
        'file_path',
        'file_size',
        'mime_type',
        'uploaded_by',
        'description',
    ];

    // Document types
    const TYPE_CITIZENSHIP = 'citizenship';
    const TYPE_BLUEBOOK = 'bluebook';
    const TYPE_INSURANCE = 'insurance';
    const TYPE_TAX = 'tax';
    const TYPE_AGREEMENT = 'agreement';
    const TYPE_RECEIPT = 'receipt';
    const TYPE_OTHER = 'other';

    public function transfer()
    {
        return $this->belongsTo(VehicleTransfer::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getDocumentTypeTextAttribute()
    {
        $types = [
            self::TYPE_CITIZENSHIP => 'Citizenship',
            self::TYPE_BLUEBOOK => 'Bluebook',
            self::TYPE_INSURANCE => 'Insurance',
            self::TYPE_TAX => 'Tax Document',
            self::TYPE_AGREEMENT => 'Agreement',
            self::TYPE_RECEIPT => 'Receipt',
            self::TYPE_OTHER => 'Other',
        ];
        return $types[$this->document_type] ?? $this->document_type;
    }
}