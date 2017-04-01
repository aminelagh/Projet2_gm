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
use \Exception;

class DirectController extends Controller
{
  public function home()
  {
    return view('Espace_Direct.dashboard');
  }

  //affiche tt les formulaire d'ajout de la partie Direction
  public function addForm($param)
  {
      $categories   = DB::table('categories')->get();
      $fournisseurs = DB::table('fournisseurs')->get();
      $marques      = DB::table('marques')->get();

    switch($param)
    {
      case 'categorie':   return view('Espace_Direct.add-categorie-form');    break;
      case 'fournisseur': return view('Espace_Direct.add-fournisseur-form')->with('data', DB::table('fournisseurs')->get());  break;
      case 'marque':      return view('Espace_Direct.add-marque-form')->with('data', DB::table('marques')->get());      break;
      case 'magasin':     return view('Espace_Direct.add-magasin-form')->with('data' , DB::table('magasins')->get() );      break;
      case 'article':     return view('Espace_Direct.add-article-form')->with(['fournisseurs' => $fournisseurs , 'categories' => $categories]); break;
    }
  }

  /*
  retourner la vue pour afficher les tables
  */
  public function lister($param)
  {
    switch($param)
    {
      case 'categories':   $data = DB::table('categories')->get();   return view('Espace_Direct.liste-categories')->with('data',$data);    break;
      case 'fournisseurs': $data = DB::table('fournisseurs')->get(); return view('Espace_Direct.liste-fournisseurs')->with('data',$data);  break;
      case 'articles':     $data = DB::table('articles')->get();     return view('Espace_Direct.liste-articles')->with('data',$data);      break;
      case 'marques':      $data = DB::table('marques')->get();      return view('Espace_Direct.liste-marques')->with('data',$data);      break;
      case 'magasins':     $data = DB::table('magasins')->get();     return view('Espace_Direct.liste-magasins')->with('data',$data);      break;
      default: return "Erreur lister !!!".$param;
    }
  }


  /*********************
  Fonction pour effacer une ligne d'une table
  ***********************/
  public function delete($p_table,$p_id)
  {
   try
   {
     switch ($p_table)
     {
       case 'categories':   DB::table('categories')->where('id_categorie', $p_id)->delete();      return back()->withInput()->with('alert_success','Categorie with id: <strong>'.$p_id.'</strong> was deleted successfully');   break;
       case 'fournisseurs': DB::table('fournisseurs')->where('id_fournisseur', $p_id)->delete();  return back()->withInput()->with('alert_success','Fournisseur with id: <strong>'.$p_id.'</strong> was deleted successfully'); break;
       case 'articles':     DB::table('articles')->where('id_article', $p_id)->delete();          return back()->withInput()->with('alert_success','Article with id: <strong>'.$p_id.'</strong> was deleted successfully');     break;
       case 'marques':      DB::table('marques')->where('id_marque', $p_id)->delete();            return back()->withInput()->with('alert_success','Marque with id: <strong>'.$p_id.'</strong> was deleted successfully');      break;
       case 'magasins':     DB::table('magasins')->where('id_magasin', $p_id)->delete();          return back()->withInput()->with('alert_success','Magasin with id: <strong>'.$p_id.'</strong> was deleted successfully');     break;
       default: return "Erreur delete !!!";
     }
   }
   catch(Exception $ex)
   {
     return back()->with('alert_danger','erreur!! <strong>'.$ex->getMessage().'</strong> ');
   }
  }

   /*********************
    Valider L'ajout
  ***********************/
  public function submitAdd($param)
  {
   switch($param)
   {
     case 'magasin':       return $this->submitAddMagasin(); break;
     case 'marque':        return $this->submitAddMarque(); break;
     case 'fournisseur':   return $this->submitAddFournisseur(); break;
     default: return 'erruer: at DirectController@submitAdd';
   }
  }








  //Valider l'ajout de : Magasin
  public function submitAddMagasin()
  {
    if( request()->get('submit') == 'verifier' )
    {
      if( request()->get('email')==null || request()->get('agent')==null || request()->get('ville')==null || request()->get('telephone')==null || request()->get('adresse')==null  )
        return redirect()->back()->withInput()->with('alert_info','il est préférable de remplir tous les champs.');
      if( Exists('magasins', 'libelle', request()->get('libelle')) )
        return redirect()->back()->withInput()->with('alert_warning','Le magasin <strong>'.request()->get('libelle').'</strong> exist deja.');
      else
       return redirect()->back()->withInput()->with('alert_success','Rien à signaler, vous pouvez valider');
    }
    else if( request()->get('submit') == 'valider' )
    {
      $item = new Magasin;
      $item->libelle      = request()->get('libelle');
      $item->email        = request()->get('email');
      $item->agent        = request()->get('agent');
      $item->ville        = request()->get('ville');
      $item->telephone    = request()->get('telephone');
      $item->adresse      = request()->get('adresse');
      $item->description  = request()->get('description');
      $item->save();
      return redirect()->back()->with('alert_success','Le Magasin <strong>'.request()->get('libelle').'</strong> a bien été ajouté.');
    }
    else
    {
      return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur de Redirection</strong><br> from: DirectController@submitAdd (submitAddMagasin)');
    }
  }

  //Valider l'ajout de : Marque
  public function submitAddMarque()
  {
    if( request()->get('submit') == 'verifier' )
    {
      if( request()->get('libelle')==null )
       return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur !!</strong> veuillez remplir le champ libelle');

      if( request()->get('description')==null )
       return redirect()->back()->withInput()->with('alert_info','il est préférable de remplir le champs description aussi.');
      else
       return redirect()->back()->withInput()->with('alert_success','Rien à signaler, vous pouvez valider.');
    }
    else if( request()->get('submit') == 'valider' )
    {
      if( request()->get('libelle')==null )
       return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur !!</strong> veuillez remplir le champ libelle');

      $item = new Marque;
      $item->libelle      = request()->get('libelle');
      $item->description  = request()->get('description');
      $item->save();
      return redirect()->back()->with('alert_success','La Marque <strong>'.request()->get('libelle').'</strong> a bien été ajouté.');
    }
    else
    {
      return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur de Redirection</strong><br> from: DirectController@submitAdd (submitAddMarque)');
    }
  }


  //Valider l'ajout de Fournisseur
  public function submitAddFournisseur()
  {
    if( request()->get('submit') == 'verifier' )
    {
      if( request()->get('libelle')==null || request()->get('code')==null )
       return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur !!</strong> veuillez remplir les champs Code et Libelle');

      if( request()->get('email')==null || request()->get('agent')==null || request()->get('telephone')==null )
       return redirect()->back()->withInput()->with('alert_info','il est préférable de remplir les champs agent, email et telephone aussi.');

      if( Exists('fournisseurs', 'code', request()->get('code') ) && Exists('fournisseurs', 'libelle', request()->get('libelle') ) )
        return redirect()->back()->withInput()->with('alert_warning','Le code et le libelle ont déjà été utilisés pour un autre fournisseur.');

      if( Exists('fournisseurs', 'code', request()->get('code') ) || Exists('fournisseurs', 'libelle', request()->get('libelle') ) )
        return redirect()->back()->withInput()->with('alert_warning','Le code ou le libelle a déjà été utilisé pour un autre fournisseur.');

      else
       return redirect()->back()->withInput()->with('alert_success','Rien à signaler, vous pouvez valider.');
    }
    else if( request()->get('submit') == 'valider' )
    {
      if( request()->get('libelle')==null )
       return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur !!</strong> veuillez remplir le champ libelle');

      $item = new Fournisseur;
      $item->code         = request()->get('code');
      $item->libelle      = request()->get('libelle');
      $item->agent        = request()->get('agent');
      $item->email        = request()->get('email');
      $item->telephone    = request()->get('telephone');
      $item->fax          = request()->get('fax');
      $item->description  = request()->get('description');
      $item->save();
      return redirect()->back()->with('alert_success','Le Fournisseur <strong>'.request()->get('code').': '.request()->get('libelle').'</strong> a bien été ajouté.');
    }
    else
    {
      return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur de Redirection</strong><br> from: DirectController@submitAdd (submitAddMarque)');
    }
  }











}
