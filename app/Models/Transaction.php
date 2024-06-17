<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // use HasFactory; // Hapus atau komentari baris ini jika tidak diperlukan

    protected $fillable = [
        'category', 'description', 'date_update', 'user', 'add_transaction', 'withdraw_transaction'
    ];
}