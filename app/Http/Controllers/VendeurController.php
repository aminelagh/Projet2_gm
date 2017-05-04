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
use App\Models\Mode_paiement;
use App\Models\Paiement;
use Carbon\Carbon;
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
                $data = collect(DB::select("call getVentesUser(" . $id_user . ");"));
                return view('Espace_Vend.liste-transactions')->with('data', $data);
                break;
            case 'trans_articles':
                $data = collect(DB::select("call getTrans_Articles(" . $p_id . ");"));
                if ($data->isEmpty())
                    return redirect()->back()->withInput()->with("alert_warning", "cette vente n'a pas de detail.");
                else {
                    $total = 0;
                    foreach ($data as $item) {
                        $total += getTTC($item->prix_vente) * $item->quantite;
                    }
                    return view('Espace_Vend.liste-trans_articles')->with(['data' => $data, 'total' => $total]);
                }
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
        return "VendeurController@detailTrans";

        $data = Trans_Article::where('id_transaction', $p_id)->get();
        if ($data->isEmpty())
            return redirect()->back()->withInput()->with('alert_warning', 'Cette transaction ne contient aucun article.');
        else
            return view('Espace_Vend.detail-transaction')->with('data', $data);
    }


    /*public function getMagasin($p_id_mag)
    {
        $data = collect(DB::select("call getArticlesForAjout(" . $p_id_mag . "); "));
        return view('Espace_Vend._nav_menu_2')->with(['data' => $data]);
    }*/


    // afficher le formulaire de creation de vente
    public function addFormVente()
    {
        $p_id_magasin = 1;//from variable de session
        $now = new Carbon();

        $data = collect( DB::select("call getStockOfMagasin(" . $p_id_magasin . "); ") );
        $modes_paiement = Mode_paiement::all();

        //dump($data);
        //array_add(['name' => 'Desk'], 'price', 100);

        //dump($data);


        foreach ($data as $item)
        {
            /*$x = array($item);
            $a = array_add($x, "hasPromotion",10);

            dump($x);
            dump($a);
            echo "<hr>";*/

            dump($item);
            $data->put('price', 100)->;
        }



        //$p = Promotion::where('id_magasin',$p_id_magasin)->where('active',true)->get();
        /*$p = Promotion::all();

        foreach ($p as $item )
        {
            echo $item->id_promotion;
            $d = Carbon::parse($item->date_debut );
            $f = Carbon::parse($item->date_fin );

            if( $now->greaterThanOrEqualTo($d) && $now->lessThanOrEqualTo($f) )
                echo " in";
            else echo " out";

            echo "<hr>";
        }
*/






        //dump($data);dump($modes_paiement);return 'a';

        /*if ($data == null)
            return redirect()->back()->withInput()->with("alert_warning", "Le stock de votre magasin est vide, veuillez faire une demande d'alimentation du stock pour procéder avec les ventes.");

        else
            return view('Espace_Vend.add-vente-form')->with( ['data' => $data ,'promotions' => $promotions, 'modes_paiement' => $modes_paiement] );
        */
    }


    // Valider l'ajout des ventes
    public function submitAddVente()
    {

        //Alertes et messages d'erreur
        $alert1 = "";
        $alert2 = "";
        $error1 = false;
        $error2 = false;
        $nbre_articles = 0;

        //array des element du formulaire
        $id_article = request()->get('id_article');
        $designation_c = request()->get('designation_c');
        $quantiteV = request()->get('quantiteV');
        $prix_vente = request()->get('prix_vente');
        $quantite = request()->get('quantite');

        $id_magasin = request()->get('id_magasin');
        $id_user = request()->get('id_user');
        $id_typeTrans = request()->get('id_typeTrans');
        //$id_paiement    =  collect(DB::select("call getPaiementID(); "));
        $id_mode = request()->get('mode');

        return 'a';


        //test pour recuperer la derniere ligne de transaction et lui ajouter 1 si elle n'était pas nulle
        $last_transaction = Transaction::orderBy('created_at', 'desc')->first();
        if ($last_transaction->id_transaction == null)
            $id = 1;
        else {
            $id = $last_transaction->id_transaction + 1;
        }
        //test pour recuperer la derniere ligne de l'id paiement et lui ajouter 1 si elle n'était pas nulle
        $id_paiement = Paiement::orderBy('created_at', 'desc')->first();
        if ($id_paiement->id_paiement == null)
            $id_p = 1;
        else {
            $id_p = $id_paiement->id_paiement + 1;
        }

        //Insertion d'une transaction et d'un paiement
        $item2 = new Transaction;
        $item3 = new Paiement;

        $item3->id_paiement = $id_p;
        $item3->id_mode = $id_mode;

        $item2->id_transaction = $id;
        $item2->id_magasin = $id_magasin;
        $item2->id_user = $id_user;
        $item2->id_typeTrans = $id_typeTrans;
        $item2->id_paiement = $id_p;

        try {
            $item3->save();
            $item2->save();
        } catch (Exception $e) {
            $error2 = true;
            $alert2 = $alert2 . "<li>Erreur d'ajout de la vente ayant l'id : <b>" . $id . "</b> Message d'erreur: " . $e->getMessage() . ". ";
        }


        //Boucle d'ajout des articles dans trans_article
        for ($i = 1; $i <= count($id_article); $i++) {

            if ($quantite[$i] == null) {
                $alert1 = $alert1 . "<li> " . $i . ": <b></b>: vous avez oublier de specifier la quantite vendue de l'article :" . $designation_c[$i];
                $error1 = true;
            }

            if ($quantite[$i] != null) {
                $item = new Trans_Article;
                $item->id_article = $id_article[$i];
                $item->id_transaction = $id;
                $item->quantite = $quantite[$i];

                try {

                    $item->save();
                    $nbre_articles++;
                } catch (Exception $e) {
                    $error2 = true;
                    $alert2 = $alert2 . "<li>Erreur d'ajout de la vente d'article: <b>" . $designation_c[$i] . "</b> Message d'erreur: " . $e->getMessage() . ". ";
                }
            }
        }

        if ($error1)
            back()->withInput()->with('alert_warning', $alert1);
        if ($error2) {
            back()->withInput()->with('alert_danger', $alert2);
        }

        return redirect()->back()->with('alert_success', 'L\'ajout de la vente s\'est effectué avec succès. Le nombre d\'articles est : ' . $nbre_articles);
    }


}
