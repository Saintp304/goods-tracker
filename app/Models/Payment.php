<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    public const TYPE_PAY_ON_DELIVERY = 'pay_on_delivery';
    public const TYPE_INSTANT = 'instant';

    public const METHOD_CASH = 'cash';
    public const METHOD_BANK_TRANSFER = 'bank_transfer';
    public const METHOD_CARD = 'card';
    public const METHOD_PAYPAL = 'paypal';
    public const METHOD_CRYPTO = 'crypto';

    public static function getPaymentTypes(): array
    {
        return [
            self::TYPE_PAY_ON_DELIVERY => 'Pay on Delivery',
            self::TYPE_INSTANT => 'Instant Payment',
        ];
    }

    public static function getPaymentMethods(): array
    {
        return [
            self::METHOD_CASH => 'Cash',
            self::METHOD_BANK_TRANSFER => 'Bank Transfer',
            self::METHOD_CARD => 'Card',
            self::METHOD_PAYPAL => 'PayPal',
            self::METHOD_CRYPTO => 'Crypto',
        ];
    }

    protected $fillable = [
        'invoice_id',
        'payment_type',
        'amount',
        'payment_date',
        'payment_method',
        'transaction_reference',
        'payment_proof',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'datetime',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function receipt(): HasOne
    {
        return $this->hasOne(Receipt::class);
    }

    public function getPaymentTypeLabel(): string
    {
        return self::getPaymentTypes()[$this->payment_type] ?? $this->payment_type;
    }

    public function getPaymentMethodLabel(): string
    {
        return self::getPaymentMethods()[$this->payment_method] ?? $this->payment_method;
    }
}
