<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $table = 'categories';

    private $id_categorie;
    private $libelle;
    private $description;
    private $created_at;
    private $updated_at;

    protected $fillable=['libelle','description'];

    public function hello(){}

}
