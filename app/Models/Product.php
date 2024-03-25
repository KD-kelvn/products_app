<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function userRatings()
    {
        return $this->hasMany(UserRating::class);
    }

    // SCOPE WITH RATINGS
    public function scopeWithRatings(Builder $query)
    {
        return $query->with(['userRatings' => function ($query) {
            $query->select('product_id', 'rating');
        }]);
    }

 public function scopeWithAvgRating(Builder $query)
{
    return $query->with(['userRatings' => function ($query) {
        $query->select('product_id', 'rating', 'rating_datetime', 'user_id');
            
    }]);
}

}
