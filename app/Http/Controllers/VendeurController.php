<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\Role;
use App\Models\Magasin;
use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\Article;
use App\Models\Marque;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\Trans_Article;
use App\Models\Type_transaction;
use App\Models\Promotion;
use App\Models\ModePaiement;
use App\Models\Paiement;
use \Exception;

class VendeurController extends Controller

//Afficher la page d'acceuil de l'Espace Vendeur
{
    public function home()
    {
        return view('Espace_Vend.dashboard');
    }

    //Lister les ventes,les promotions et le stock du magasin
    public function lister($p_table, $p_id)
    {
        $id_magasin = 1; //variable de session ici
        $id_user = 1;//Variable de session ici

        switch ($p_table) {
            case 'transactions':
                $data = collect( DB::select("call getVentesUser(" . $id_user . ");") );
                return view('Espace_Vend.liste-transactions')->with('data', $data);
                break;
            case 'ventes':
                $data = collect(DB::select("call getVentesMagasin(" . $p_id . ");"));
                return view('Espace_Vend.liste-ventes')->with('data', $data);
                break;
            case 'promotions':
                $data = collect(DB::select("call getPromotionsForMagasin(" . $id_magasin . "); "));
                return view('Espace_Vend.liste-promotions')->with('data', $data);
                break;
            case 'stocks':
                $data = collect(DB::select("call getStockOfMagasin(" . $id_magasin . "); "));
                //$data = Stock::where('id_magasin',$p_id)->get();  dump($data);
                return view('Espace_Vend.liste-stocks')->with('data', $data);
                break;
            default:
                return redirect()->back()->withInput()->with('alert_warning', "Erreur de redirection. VendeurController@lister");
                break;
        }
    }

    //Afficher le detail de la transaction
    public function detailTrans($p_id)
    {
        $data = Trans_Article::where('id_transaction', $p_id)->get();
        if ($data->isEmpty())
            return redirect()->back()->withInput()->with('alert_warning', 'Cette transaction ne contient aucun article.');
        else
            return view('Espace_Vend.detail-transact')->with('data', $data);
    }


    public function getMagasin($p_id_mag)
    {

        $data = collect(DB::select("call getArticlesForAjout(" . $p_id_mag . "); "));
        return view('Espace_Vend._nav_menu_2')->with(['data' => $data]);
    }

}
