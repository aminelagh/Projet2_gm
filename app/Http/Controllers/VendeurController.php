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
use Illuminate\Support\Facades\Session;
use \Exception;

class VendeurController extends Controller

//Afficher la page d'acceuil de l'Espace Vendeur
{
    public function home()
    {
        Session::put('id_magasin', 1);
        Session::put('id_user', 1);

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
        $p_id_magasin = Session::get('id_magasin');

        $data = collect(DB::select("call getStockOfMagasin(" . $p_id_magasin . "); "));
        $modes_paiement = Mode_paiement::all();

        if ($data == null)
            return redirect()->back()->withInput()->with("alert_warning", "Le stock de votre magasin est vide, veuillez faire une demande d'alimentation du stock pour procéder avec les ventes.");

        else
            return view('Espace_Vend.add-vente-form')->with(['data' => $data, 'modes_paiement' => $modes_paiement]);
    }


    // Valider l'ajout des ventes
    public function submitAddVente()
    {
        $id_magasin = Session::get('id_magasin');

        //array des element du formulaire ******************
        $id_stock = request()->get('id_stock');
        $quantite = request()->get('quantite');
        $id_article = request()->get('id_article');
        //**************************************************

        //not array ******************************
        $id_mode_paiement = request()->get('id_mode_paiement');
        $ref = request()->get('ref');
        $taux_remise = request()->get('taux_remise');
        $raison = request()->get('raison');
        //****************************************

        //variables ***************************
        $alert1 = "";
        $alert2 = "";
        $error1 = false;
        $error2 = false;
        $nbre_articles = 0;
        //***********************************
        echo "id_article";
        dump($id_article);
        echo "id_stock";
        dump($id_stock);
        echo "quantite";
        dump($quantite);

        echo "id_mode_paiement";
        dump($id_mode_paiement);
        echo "ref";
        dump($ref);
        echo "taux_remise";
        dump($taux_remise);
        echo "raison";
        dump($raison);

        return 'a';

        //*********************************
        //verifier que l utilisateur a saisi 1..* quantites, sinn redirect back
        $hasItems = false;
        for ($i = 1; $i <= count($id_stock); $i++) {
            if ($quantite[$i]!=null) {
                $hasItems = true;
                break;
            }
        }
        if (!$hasItems)
            return redirect()->back()->withInput()->with('alert_info', "Vous devez saisir les quantités à alimenter.");
        //**********************************

        //****************************************
        //recuperer la derniere transaction pour en retirer son id
        $lastTransaction = DB::table('transactions')->orderBy('id_transaction', 'desc')->first();

        if ($lastTransaction == null)
            $id = 1;
        else
            $id = $lastTransaction->id_transaction + 1;
        //****************************************

        //**************************************
        //creation de la transation & chercher l id_type_transaction pour l alimentation du stock
        $id_type_transaction_ajouter = Type_transaction::where('libelle', 'ajouter')->get()->first()->id_type_transaction;

        $transaction = new Transaction();
        $transaction->id_transaction = $id;
        $transaction->id_user = 3;    //from variable de session
        $transaction->id_magasin = $id_magasin;
        $transaction->id_type_transaction = $id_type_transaction_ajouter;
        $transaction->id_paiement = null;
        try {
            $transaction->save();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with("alert_danger", "Erreur de la création de la transacation dans la base de données, veuillez reassayer ultérieurement.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>.");
        }
        //**************************************

        //**************************************
        //Boucle pour traiter chaque article
        for ($i = 1; $i <= count($id_stock); $i++) {

            //verifier si l utilisateur n a pas saisi les quantites
            if ($quantite[$i] == null) continue;

            try {
                //Creation et insertion de trans_article
                $trans_article = new Trans_article();
                $trans_article->id_transaction = $id;
                $trans_article->id_article = $id_article[$i];
                $trans_article->quantite = $quantite[$i];
                $trans_article->save();
                $nbre_articles++;

                //Executer la procedure de modification de stock
                DB::select("call incrementStock(" . $id_stock[$i] . "," . $quantite[$i] . ");");

            } catch (Exception $e) {
                $alert2 = $alert1 . "<li>Erreur,  article: " . getChamp("articles", "id_article", $id_article[$i], "designation_c") . ". Message d'erreur: <b>" . $e->getMessage() . "</b>.";
                $error2 = true;
            }
        }
        //**************************************

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //imprimer un document d ajout au stock

        if ($error1)
            back()->withInput()->with('alert_warning', $alert1);
        if ($error2)
            back()->withInput()->with('alert_danger', $alert2);

        if ($nbre_articles > 1)
            return redirect()->back()->with('alert_success', 'Alimentation de ' . $nbre_articles . ' aticle.');
        else
            return redirect()->back()->with('alert_success', 'Alimentation de ' . $nbre_articles . ' articles.');

    }

    public function submitAddVente2()
    {
        //Alertes et messages d'erreur
        $alert1 = "";
        $alert2 = "";
        $error1 = false;
        $error2 = false;
        $nbre_articles = 0;
        //********************************

        //array des element du formulaire
        $id_stock = request()->get('id_stock');
        $id_article = request()->get('id_article');
        $quantite = request()->get('quantite');
        //**************************************************

        //not array ******************************
        $id_mode_paiement = request()->get('id_mode_paiement');
        $ref = request()->get('ref');
        $taux_remise = request()->get('taux_remise');
        $raison = request()->get('raison');
        //****************************************

        //verifier que l utilisateur a saisi 1..* quantites, sinn redirect back
        $hasItems = false;
        for ($i = 1; $i <= count($id_stock); $i++) {
            if ($quantite[$i] > 0) {
                $hasItems = true;
                break;
            }
        }
        if (!$hasItems)
            return "not items";//redirect()->back()->withInput()->with('alert_info', "Vous devez saisir les quantités à alimenter.");
        //**********************************





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


    public function addFormVente1()
    {
        $p_id_magasin = Session::get('id_magasin');
        $now = new Carbon();

        $data = collect(DB::select("call getStockOfMagasin(" . $p_id_magasin . "); "));
        $modes_paiement = Mode_paiement::all();

        $p = Promotion::where('id_magasin', $p_id_magasin)->where('active', true)->get();
        $elements = null;
        $i = 0;


        //dump($data);
        foreach ($data as $item) {
            $i = $i + 1;

            if ($elements == null) {
                $elements = array($item);
            } else {
                array_push($elements, $item);
            }


            $promo = collect(Promotion::where('id_article', $item->id_article)->where('id_magasin', $p_id_magasin)->where('active', true)->get());
            if (!$promo->isEmpty()) {
                $d = Carbon::parse($promo->first()->date_debut);
                $f = Carbon::parse($promo->first()->date_fin);
                if ($now->greaterThanOrEqualTo($d) && $now->lessThanOrEqualTo($f)) {
                    $x = array_merge((array)$item, (array)$promo);
                }
            } else {
                $x = array_merge((array)$item, (array)$promo->first());
            }

            dump($x);


        }

        dump($elements);


        /*foreach ($data as $item) {

            $elements = collect($item);

            //dump(collect($item));
            $promo = collect(Promotion::where('id_article', $item->id_article)->where('id_magasin', $p_id_magasin)->where('active', true)->get());

            if (!$promo->isEmpty()) {
                $d = Carbon::parse($promo->first()->date_debut);
                $f = Carbon::parse($promo->first()->date_fin);
                if ($now->greaterThanOrEqualTo($d) && $now->lessThanOrEqualTo($f)) {
                    //$elements = collect(null)->push($item);$elements->union("hasPromotion", true);$elements->union("tauxPromotion", $promo->first()->taux);
                    $elements = $elements->union(collect($promo));
                }
            } else {
                //$elements->union("hasPromotion", false);$elements->union("tauxPromotion", null);
                $elements = $elements->union($elements);
            }
        }*/
        //dump($elements);

        /*dump( $elements) ;
        foreach ($elements as $item)
        {
            dump($item);
        }*/


//$x = collect($item)->put('hasPromotion', true)->put('taux_promotion', true);
        //dump($x);
        //dump($elements);
        //echo "<hr>";
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


}
