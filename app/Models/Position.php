<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

         protected $guarded = [];

      public function jop()
    {
        return $this->belongsTo(Jop::class );
    }
     public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
