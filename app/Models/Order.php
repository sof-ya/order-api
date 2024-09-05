<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id',
        'partnership_id',
        'user_id',
        'description',
        'date',
        'address',
        'amount',
        'status',
    ];

    public function workers(): BelongsToMany {
        return $this->belongsToMany(Worker::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function partnership(): BelongsTo {
        return $this->belongsTo(Partnership::class);
    }

    public function type(): BelongsTo {
        return $this->belongsTo(OrderType::class, "type_id");
    }
}
