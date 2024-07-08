<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User; 
use App\Models\TransactionItem; 

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'users_id',
        'address', 
        'payment',
        'total_price',
        'shipping_price',
        'status',
    ];

    /**
     * Get the user that owns the transaction.
     */
    public function user() 
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    /**
     * Get the items for the transaction.
     */
    public function items()
    {
        return $this->hasMany(TransactionItem::class, 'transactions_id', 'id'); // Sesuaikan penulisan nama model
    }
}
