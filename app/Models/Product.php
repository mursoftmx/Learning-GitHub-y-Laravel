<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\AvailableScope;

class Product extends Model
{
    protected $table = 'products';

    protected $with = ['images'];       // Agregar esta relacion a la consulta, siempre traeremos un producto con sus imagenes

    // use HasFactory;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'price',
        'stock',
        'status'
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new AvailableScope);
    }

    public function carts() 
    {
        // return $this->belongsToMany(Cart::class)->withPivot('quantity');
        return $this->morphedByMany(Cart::class, 'productable')->withPivot('quantity');
    }

    public function orders() 
    {
        // return $this->belongsToMany(Order::class)->withPivot('quantity');
        return $this->morphedByMany(Order::class, 'productable')->withPivot('quantity');
    }

    public function images() 
    {
        return $this->morphMany(Image::class,'imageable');
    }

    public function scopeAvailable($query) 
    {
        return $query->where('status','available');
    }

    public function getTotalAttribute()
    {
        return $this->price * $this->pivot->quantity;
    }
}
