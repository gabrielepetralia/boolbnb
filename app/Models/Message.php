<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
      "name",
      "email",
      "msg_text",
      "apartment_id",
      "sent_date",
    ];

  public function apartment()
  {
    return $this->belongsTo(Apartment::class);
  }
}
