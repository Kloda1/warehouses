<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
        public function parent()
    {
        return $this->belongsTo(Warehouse::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Warehouse::class, 'parent_id');
    }

     public function getAllChildren()
    {
        return $this->children()->with('allChildren');
    }

     public function getTotalStock()
    {
        $total = $this->items()->sum('quantity');
        
        foreach ($this->children as $child) {
            $total += $child->getTotalStock();
        }
        
        return $total;
    }
}
