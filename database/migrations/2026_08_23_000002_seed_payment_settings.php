<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use App\Models\PaymentSetting;

/**
 * Seed default payment settings for development.
 *
 * This migration ensures that the public payment page always has at least
 * one enabled payment method so customers are not presented with the
 * "No payment methods currently available" message.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Bank Transfer
        PaymentSetting::updateOrCreate(
            ['method' => 'bank_transfer'],
            [
                'enabled' => true,
                'bank_name' => 'Demo Bank',
                'account_name' => 'Goods Tracker Ltd.',
                'account_number' => '12345678',
                'iban' => 'GB00DEMO12345678',
                'swift_bic' => 'DEMO123',
                'instructions' => 'Please transfer the exact amount to the above account using the provided IBAN and SWIFT/BIC.',
            ]
        );

        // PayPal
        PaymentSetting::updateOrCreate(
            ['method' => 'paypal'],
            [
                'enabled' => true,
                'paypal_email' => 'payments@goodstracker.com',
                'instructions' => 'Send the payment via PayPal to the email address above.',
            ]
        );

        // Crypto (USDT on TRC20)
        PaymentSetting::updateOrCreate(
            ['method' => 'crypto'],
            [
                'enabled' => true,
                'crypto_currency' => 'USDT',
                'crypto_network' => 'TRC20',
                'wallet_address' => 'TRC20DemoWalletAddress',
                'instructions' => 'Send USDT (TRC20) to the wallet address above. Include your transaction reference.',
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        PaymentSetting::whereIn('method', ['bank_transfer', 'paypal', 'crypto'])->delete();
    }
};
