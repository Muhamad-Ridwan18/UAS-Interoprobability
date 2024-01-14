<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
     protected $table = 'transactions';
     protected $fillable = ['user_id', 'amount', 'category_id', 'description', 'date'];

     public function user()
     {
          return $this->belongsTo(User::class);
     }
}