<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentHistory extends Model
{
  protected $fillable = [
    'shipment_id',
    'location',
    'info'
  ];
}