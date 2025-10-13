<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pdf extends Model
{
  protected $fillable = ['titulo','ano','disk','path','mime','size','user_id'];
}

