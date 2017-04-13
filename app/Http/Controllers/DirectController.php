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

class DirectController extends Controller
{
  public function home()
  {
    return view('Espace_Direct.dashboard');
  }









  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

  /****************************
  Afficher le fomulaire d'ajout pour le stock
  ****************************/
  public function addFormStock($p_id_magasin)
  {
    $magasin = Magasin::where('id_magasin',$p_id_magasin)->first();
    $articles = Article::all();

    if( $articles == null )
      return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur !!</strong> la base de données des articles est vide, veuillez ajouter les articles avant de procéder à la création des stocks.');

    if( $magasin == null )
      return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur !!</strong> Le magasin choisi n\'existe pas .(veuillez choisir un autre magasin.)');

    else
      return view('Espace_Direct.add-stock_Magasin-form')->with(['data' => Stock::all(), 'articles' => $articles,  'magasin' => $magasin ]);
  }



  //Valider l'ajout de : Stock
  public function submitAddStock()
  {
    $id_article   = request()->get('id_article');
    $quantite     = request()->get('quantite');
    $quantite_min = request()->get('quantite_min');
    $quantite_max = request()->get('quantite_max');

    foreach( $id_article as $item )
    {
      echo "<li>".$item;
    }


    for( $i=1; $i< count($id_article) ; $i++ )
    {
      echo $id_article[$i]." ".$quantite[$i]." ".$quantite_min[$i]." ".$quantite_max[$i]."<br>";
    }

    dump ( 'id_article', request()->get('id_article'));
    dump ( 'quantite', request()->get('quantite') );
    dump ( 'quantite_min', request()->get('quantite_min') );

    dump(request());

    foreach( request()->get('quantite') as $q )
    {
      echo $q."<br>";
    }
    return 'aa';

    if( request()->get('submit') == 'verifier' )
    {
       return redirect()->back()->withInput()->with('alert_success','Verifier le stock (magasin/article).s');
    }
    else if( request()->get('submit') == 'valider' )
    {
      //if( request()->get('libelle')==null )
       //return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur !!</strong> veuillez remplir le champ libelle');

      $item = new Stock;
      $item->id_magasin    = request()->get('id_magasin');
      $item->id_article    = request()->get('id_article');
      $item->quantite      = request()->get('quantite');
      $item->quantite_min  = request()->get('quantite_min');
      $item->quantite_max  = request()->get('quantite_max');

      $item->save();
      return redirect()->back()->with('alert_success','Done');
    }
    else
    {
      return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur de Redirection</strong><br> from: DirectController@submitAdd (submitAddStock)');
    }
  }

  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@


  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@



  /*****************************************************************************
  Lister Stocks
  *****************************************************************************/
  public function listerStocks($p_id_magasin)
  {
    $data = Stock::where('id_magasin', $p_id_magasin)->get();
    if($data->isEmpty())
      return redirect()->back()->withInput()->with('alert_warning','No stock in that Shop.');

    else
      return view('Espace_Direct.liste-stocks')->with('data',$data);

  }


}
