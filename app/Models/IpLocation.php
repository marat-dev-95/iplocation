<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpLocation extends Model
{
    use HasFactory;

    protected $fillable = ['ip_address', 'country_name'];
}
