<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\FinancialService;

class Shipment extends Model
{
  protected $fillable = [
    'tracking_number',
    'sender_name',
    'sender_phone',
    'sender_address',
    'sender_country',
    'receiver_name',
    'receiver_email',
    'receiver_phone',
    'receiver_address',
    'receiver_country',
    'origin',
    'destination',
    'package_description',
    'package_type',
    'package_weight',
    'package_quantity',
    'shipment_image',
    'status',
    'eta',
    'currency',
    'payment_type',
    'subtotal',
    'tax',
  ];

  protected $casts = [
    'eta' => 'date',
  ];

  // Auto-generate tracking number and create invoice
  protected static function booted(): void
  {
    static::creating(function ($shipment) {
      if (!$shipment->tracking_number) {
        $shipment->tracking_number = 'TG-' . strtoupper(uniqid());
      }
    });

    static::created(function ($shipment) {
      // Auto-create invoice when shipment is created
      try {
        // Check if invoice already exists to prevent duplicates
        $existingInvoice = $shipment->invoice()->first();
        if (!$existingInvoice) {
          // Calculate invoice data based on shipment's configured currency and charges
          $invoiceData = [
            'invoice_number' => 'INV-' . strtoupper(uniqid()),
            'issue_date' => now()->toDateString(),
            'due_date' => now()->addDays(14)->toDateString(),
            'currency' => $shipment->currency ?? 'USD',
            'subtotal' => $shipment->subtotal ?? 0,
            'tax' => $shipment->tax ?? 0,
            'total' => ($shipment->subtotal ?? 0) + ($shipment->tax ?? 0),
            'status' => 'OPEN',
          ];

          $financialService = app(FinancialService::class);
          $financialService->createInvoice($shipment, $invoiceData);

          // Sync payment type to the newly created invoice
          $invoice = $shipment->invoice()->first();
          if ($invoice && $shipment->payment_type) {
              $invoice->payment_type = $shipment->payment_type;
              $invoice->save();
          }

          // Invoice created successfully
        }
      } catch (\Exception $e) {
        // Log error but don't fail shipment creation
        error_log("Failed to auto-create invoice for shipment {$shipment->tracking_number}: " . $e->getMessage());
      }
    });
  }

  public function getStepsAttribute(): array
  {
    $steps = [
      'pending' => 1,
      'picked_up' => 2,
      'in_transit' => 3,
      'held' => 4,
      'delivered' => 5,
      'cancelled' => 0,
    ];

    $currentLevel = $steps[$this->status] ?? 0;

    return [
      ['label' => 'Order Confirmed', 'done' => $currentLevel >= 1],
      ['label' => 'Picked by Courier', 'done' => $currentLevel >= 2],
      ['label' => 'On the Way', 'done' => $currentLevel >= 3],
      ['label' => 'Customs Hold', 'done' => $this->status === 'held'],
      ['label' => 'Delivered', 'done' => $this->status === 'delivered'],
    ];
  }

  public function histories()
  {
    return $this->hasMany(ShipmentHistory::class)->latest();
  }

  public function invoice()
  {
    return $this->hasOne(Invoice::class);
  }
}
