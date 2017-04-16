<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotions';
    protected $primaryKey = 'id_promotion';

    protected $fillable = [
      'id_promotion', 'id_article', 'id_magasin',
      'taux', 'date_debut', 'date_fin','active',
    ];
}
