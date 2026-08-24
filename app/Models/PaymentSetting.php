<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $fillable = [
        'method',
        'enabled',
        'bank_name',
        'account_name',
        'account_number',
        'iban',
        'swift_bic',
        'paypal_email',
        'crypto_currency',
        'crypto_network',
        'wallet_address',
        'instructions',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];
}
