<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id_transaction';

    protected $fillable = [
      'id_transaction', 'id_user','id_magasin' ,
      'id_type_transaction', 'id_paiement',
    ];
}
