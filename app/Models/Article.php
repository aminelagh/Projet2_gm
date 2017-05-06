<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';
    protected $primaryKey = 'id_article';

    protected $fillable = [
        'id_article', 'id_fournisseur', 'id_categorie',
        'designation_c', 'designation_l',
        'code_barre', 'num_article',
        'couleur', 'taille', 'sexe', 'prix_achat', 'prix_vente',
    ];

    public static function getPrixPromo($p_id_article, $p_id_magasin)
    {
        if (Promotion::hasPromotion($p_id_article, $p_id_magasin)) {
            $taux = Promotion::getTauxPromo($p_id_article, $p_id_magasin);
            $prixHT = Article::where('id_article', $p_id_article)->first()->prix_vente;
            $prixTTC = $prixHT * 1.2;
            $prix = $prixTTC * (1-$taux/100);
            return $prix;
        }

    }
}
