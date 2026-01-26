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
        
        //  return collect();
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

     public function getHierarchicalNameAttribute()
    {
        if ($this->parent) {
            return $this->parent->name . ' → ' . $this->name;
        }
        return $this->name;
    }

     public function getStatusTextAttribute()
    {
        return $this->is_active ? 'نشط' : 'غير نشط';
    }

     public function hasChildren()
    {
        return $this->children()->exists();
    }

     public function hasItems()
    {
        return $this->items_count > 0;
    }
} 