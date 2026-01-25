<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillRecord extends Model
{
 public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
    
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
