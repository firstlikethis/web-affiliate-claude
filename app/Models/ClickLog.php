<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClickLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'ip_address',
        'user_agent',
        'referer',
    ];

    /**
     * Get the product that owns the click log.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}