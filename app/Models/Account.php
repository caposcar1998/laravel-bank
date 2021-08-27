<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'current_balance', 'user_id'];

    /**
     * Retrieves the relationship with the user
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
