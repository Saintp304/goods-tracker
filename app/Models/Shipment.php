<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

  // Auto-generate tracking number only. No invoice is created here —
  // shipments now start with zero financials. An invoice is only created
  // once the shipment is placed on Held (see FinancialService::createOrUpdateHoldInvoice).
  protected static function booted(): void
  {
    static::creating(function ($shipment) {
      if (!$shipment->tracking_number) {
        $shipment->tracking_number = 'TG-' . strtoupper(uniqid());
      }
    });
  }

  /**
  * Whether this shipment is currently on customs hold.
  */
  public function isOnHold(): bool
  {
    return $this->status === 'held';
  }

  public function getStepsAttribute(): array
  {
    // Held is intentionally NOT its own step level — it sits at the same
    // level as "in_transit" so the ladder never appears to move backward.
    $steps = [
      'pending' => 1,
      'picked_up' => 2,
      'in_transit' => 3,
      'held' => 3,
      'cleared_transit' => 4,
      'delivered' => 5,
      'cancelled' => 0,
    ];

    $currentLevel = $steps[$this->status] ?? 0;

    $timeline = [
      ['label' => 'Order Confirmed', 'done' => $currentLevel >= 1],
      ['label' => 'Picked by Courier', 'done' => $currentLevel >= 2],
      ['label' => 'In Transit', 'done' => $currentLevel >= 3],
    ];

    // Show a "Customs Hold" step in the ladder only while actually held.
    if ($this->status === 'held') {
      $timeline[] = ['label' => 'Customs Hold',
        'done' => true,
        'flag' => true];
    }

    $timeline[] = ['label' => 'Cleared & Moving',
      'done' => $currentLevel >= 4];
    $timeline[] = ['label' => 'Delivered',
      'done' => $currentLevel >= 5];

    return $timeline;
  }

  public function histories() {
    return $this->hasMany(ShipmentHistory::class)->latest();
  }

  public function invoice() {
    return $this->hasOne(Invoice::class);
  }
}