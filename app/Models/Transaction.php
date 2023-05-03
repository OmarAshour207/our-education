<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'paidAmount',
        'currency',
        'parentEmail',
        /**
         * 1 => authorized
         * 2 => decline
         * 3 => refunded
         */
        'statusCode',
        'paymentDate',
        'parentIdentification'
    ];

    // relations

    public function user()
    {
        return $this->belongsTo(User::class, 'parentEmail');
    }
}
