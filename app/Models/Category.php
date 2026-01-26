<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'parent_id',
        'items_count',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

 
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
 
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

 
    public function items()
    {
        return $this->hasMany(Item::class);
    }

   
    public function bills()
    {
        return $this->hasManyThrough(Bill::class, Item::class);
    }

  
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

     public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }

     public function scopeSub($query)
    {
        return $query->whereNotNull('parent_id');
    }

     public function getFullPathAttribute()
    {
        $path = $this->name;
        $parent = $this->parent;
        
        while ($parent) {
            $path = $parent->name . ' → ' . $path;
            $parent = $parent->parent;
        }
        
        return $path;
    }

     public function getDepthAttribute()
    {
        $depth = 0;
        $parent = $this->parent;
        
        while ($parent) {
            $depth++;
            $parent = $parent->parent;
        }
        
        return $depth;
    }

     public function getCanDeleteAttribute()
    {
        return $this->items_count == 0 && $this->children()->count() == 0;
    }

     public function getStatusTextAttribute()
    {
        return $this->is_active ? 'نشط' : 'غير نشط';
    }

     public function getAllChildren()
    {
        $children = collect();
        
        foreach ($this->children as $child) {
            $children->push($child);
            $children = $children->merge($child->getAllChildren());
        }
        
        return $children;
    }

     public function getAllItems()
    {
        $items = $this->items;
        
        foreach ($this->getAllChildren() as $child) {
            $items = $items->merge($child->items);
        }
        
        return $items;
    }
}