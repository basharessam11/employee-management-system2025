<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
     protected $guarded = [];

      public function unit()
    {
        return $this->belongsTo(Unit::class ,'unit_id');
    }
     public function manager()
    {
        return $this->belongsTo(User::class ,'manager_id');
    }
}
