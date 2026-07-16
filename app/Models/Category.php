<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Beri tahu Intelephense bahwa fungsi magic find() itu ada
 * * @method static \App\Models\Category|null find($id)
 */
#[Fillable(['name', 'slug', 'description'])]
class Category extends Model
{
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
