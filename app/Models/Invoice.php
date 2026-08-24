<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Invoice extends Model
{
    public const STATUS_OPEN = 'OPEN';
    public const STATUS_PARTIALLY_PAID = 'PARTIALLY_PAID';
    public const STATUS_PAID = 'PAID';
    public const STATUS_CANCELLED = 'CANCELLED';

    public static function getStatusLabels(): array
    {
        return [
            self::STATUS_OPEN => 'Open',
            self::STATUS_PARTIALLY_PAID => 'Partially Paid',
            self::STATUS_PAID => 'Paid',
            self::STATUS_CANCELLED => 'Cancelled',
        ];
    }

    public function getStatusLabel(): string
    {
        return self::getStatusLabels()[$this->status] ?? $this->status;
    }

    protected $fillable = [
        'invoice_number',
        'shipment_id',
        'issue_date',
        'due_date',
        'currency',
        'subtotal',
        'tax',
        'total',
        'status',
        'payment_type',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function isOverdue(): bool
    {
        if ($this->status === 'PAID' || $this->status === 'CANCELLED') {
            return false;
        }

        if (!$this->due_date) {
            return false;
        }

        return Carbon::now()->greaterThan($this->due_date);
    }
}
