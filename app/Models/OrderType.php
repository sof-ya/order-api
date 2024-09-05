<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    
    public $timestamps = false;

    public function workers(): BelongsToMany {
        return $this->belongsToMany(Worker::class, "workers_ex_order_types", "order_type_id");
    }

    public function orders(): HasMany {
        return $this->hasMany(Order::class, "type_id");
    }
}
