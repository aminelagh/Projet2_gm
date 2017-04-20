<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Magasin;
use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\Article;
use App\Models\Marque;
use App\Models\Stock;
use \Exception;

class StockController extends Controller
{

	/*****************************************************************************
	Lister Stocks
	*****************************************************************************/
	public function listerStocks($p_id_magasin)
	{
		$data = Stock::where('id_magasin', $p_id_magasin)->get();
		if($data->isEmpty())
			return redirect()->back()->withInput()->with('alert_warning','Le stock de ce magasin est vide.');
		else
			return view('Espace_Direct.liste-stocks')->with('data',$data);
	}

	/*****************************************************************************
	Afficher le fomulaire d'ajout pour le stock
	*****************************************************************************/
	public function addStock($p_id_magasin)
	{
		$magasin = Magasin::where('id_magasin',$p_id_magasin)->first();		//$articles = Article::all();

		//Procédure stockee dans la db: permet de retourner la liste des articles qui ne figurent pas deja dans le stock de ce magasin
		$articles = collect( DB::select("call getArticlesForStock(".$p_id_magasin."); ") );
		//dump($articles);

		if( $articles == null )
			return redirect()->back()->withInput()->with('alert_warning','La base de données des articles est vide, veuillez ajouter les articles avant de procéder à la création des stocks.');

		if( $magasin == null )
			return redirect()->back()->withInput()->with('alert_warning','Le magasin choisi n\'existe pas .(veuillez choisir un autre magasin.)');

		else
			return view('Espace_Direct.add-stock_Magasin-form')->with([ 'articles' => $articles,  'magasin' => $magasin ]);
	}

	/*****************************************************************************
	Valider l'ajout des articles au stock d'un magasin
	*****************************************************************************/
	public function submitAddStock()
	{
		//id du magasin
		$id_magasin   	= request()->get('id_magasin');

		//array des element du formulaire
		$id_article   	= request()->get('id_article');
		$designation_c	= request()->get('designation_c');
		//$quantite     	= request()->get('quantite');
		$quantite_min 	= request()->get('quantite_min');
		$quantite_max 	= request()->get('quantite_max');

		$alert1 = "";		$alert2 = "";
		$error1 = false;	$error2 = false;
		$nbre_articles = 0;

		for( $i=1; $i<=count($id_article) ; $i++ )
		{
		    //verifier si l utilisateur n a pas saisi les quantites min ou Max
			if( $quantite_min[$i] == null || $quantite_max[$i] == null ) continue;

			if( $quantite_min[$i]>$quantite_max[$i] )
			{
				$alert1 = $alert1."<li><b>".$designation_c[$i]."</b>: Quantite min superieur a la quantité max.";
				$error1 = true;
			}

			if( $quantite_min[$i]<=$quantite_max[$i] && $quantite_min[$i] != null && $quantite_max[$i] != null  )
			{
				$item = new Stock;
				$item->id_magasin    = $id_magasin;
				$item->id_article    = $id_article[$i];
				$item->quantite      = 0;
				$item->quantite_min  = $quantite_min[$i];
				$item->quantite_max  = $quantite_max[$i];

				try
				{
					$item->save();
					$nbre_articles++;
				} catch (Exception $e) { $error2 = true; $alert2 = $alert2."<li>Erreur d'ajout de l'article: <b>".$designation_c[$i]."</b> Message d'erreur: ".$e->getMessage().". ";}
			}
		}

		if($error1)
			back()->withInput()->with('alert_warning',$alert1);
		if($error2)
			back()->withInput()->with('alert_danger',$alert2);

		if($error1 || $error2)
		    return redirect()->back()->withInput();
		else
        {
            if( $nbre_articles > 1 )
                return redirect()->back()->with('alert_success','Ajout de '.$nbre_articles.' aticle.');
            else
                return redirect()->back()->with('alert_success','Ajout de '.$nbre_articles.' articles.');
        }
	}


    /*****************************************************************************
    Afficher le formulaire d'alimentation de stock (liste du stock )
    ******************************************************************************/
    public function supplyStock($p_id_magasin)
    {
        //procedure pour recuperer le stock d'un magasin
        $data = collect( DB::select("call getStockForSupply(".$p_id_magasin.");") );
        $magasin = Magasin::where('id_magasin',$p_id_magasin)->first();

        if( $data == null )
            return redirect()->back()->withInput()->with('alert_warning','Veuillez créer le stock avant de procéder à son alimentation');

        if( $magasin == null )
            return redirect()->back()->withInput()->with('alert_warning',"Le magasin choisi n'existe pas .(veuillez choisir un autre magasin.)");

        else
            return view('Espace_Direct.supply-stock_Magasin-form')->with([ 'data' => $data,  'magasin' => $magasin ]);

    }


}
