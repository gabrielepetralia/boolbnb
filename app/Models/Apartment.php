<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'slug',
    'num_rooms',
    'num_beds',
    'num_bathrooms',
    'square_meters',
    'coordinates',
    'description',
    'address',
    'visible',
    'img_path',
    'price',
    'user_id'
  ];

  protected $spatialFields = [
    'coordinate',
  ];


  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function services()
  {
    return $this->belongsToMany(Service::class);
  }

  public function sponsorships()
  {
    return $this->belongsToMany(Sponsorship::class)->withPivot('end_date');
  }

  public function views()
  {
    return $this->hasMany(View::class);
  }

  public function images()
  {
    return $this->hasMany(Image::class);
  }

  public function messages()
  {
    return $this->hasMany(Message::class);
  }
}
