<?php


use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Track Shipment')] class extends Component
{
  public string $trackingNumber = '';
  public bool $searched = false;

  public array $shipment = [];

  // ✅ Allow trackingNumber from URL query string
  protected $queryString = ['trackingNumber'];

  public function mount() {
    if ($this->trackingNumber) {
      $this->track(); // automatically run tracking if URL has number
    }
  }

  public function track() {
    $this->validate([
      'trackingNumber' => 'required|min:6',
    ]);

    $this->shipment = [
      'tracking_number' => $this->trackingNumber,
      'status' => 'On the Way',
      'current_location' => 'Lagos Hub',
      'eta' => 'Feb 10, 2026',
      'steps' => [
        ['label' => 'Order Confirmed',
          'done' => true],
        ['label' => 'Picked by Courier',
          'done' => true],
        ['label' => 'On the Way',
          'done' => true],
        ['label' => 'Customs Hold',
          'done' => false],
        ['label' => 'Delivered',
          'done' => false],
      ],
      'history' => [
        [
          'location' => 'Abuja',
          'date' => '2026-02-01 08:00',
          'info' => 'Shipment picked up from sender',
        ],
        [
          'location' => 'Ibadan',
          'date' => '2026-02-02 12:30',
          'info' => 'Arrived at regional hub',
        ],
        [
          'location' => 'Lagos',
          'date' => '2026-02-03 09:45',
          'info' => 'Out for delivery',
        ],
      ],
    ];

    $this->searched = true;
  }
};