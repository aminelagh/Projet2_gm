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

  //affiche les formulaire d'ajout de la partie Direction
  public function addForm($param)
  {
    switch($param)
    {
      case 'categorie':   return view('Espace_Direct.add-categorie-form')->withData( Categorie::all() );    break;
      case 'fournisseur': return view('Espace_Direct.add-fournisseur-form')->withData( Fournisseur::all() );  break;
      case 'magasin':     return view('Espace_Direct.add-magasin-form')->withData( Magasin::all() );      break;
      case 'article':     return view('Espace_Direct.add-article-form')->with(['data' => Article::all() , 'fournisseurs' => Fournisseur::all() , 'categories' => Categorie::all() ]); break;
      default: return 'DirectController@addForm($param)';
    }
  }


  //afficher les formulaire de modification
  public function updateForm($p_table, $p_id)
  {
    $categories   = DB::table('categories')->get();
    $fournisseurs = DB::table('fournisseurs')->get();

    switch($p_table)
    {
      case 'categories':   return view('Espace_Direct.update-categorie-form')->withData(  Categorie::find($p_id) );     break;
      case 'fournisseurs': return view('Espace_Direct.update-fournisseur-form')->withData( Fournisseur::find($p_id) );  break;
      case 'magasins':     return view('Espace_Direct.update-magasin-form')->withData( Magasin::find($p_id) );          break;
      case 'articles':     return view('Espace_Direct.update-article-form')->with(['data' =>  Article::find($p_id) , 'fournisseurs' => $fournisseurs , 'categories' => $categories] ); break;
      default: return 'DirectController@updateForm($param)';
    }
  }

  /****************************************
  retourner la vue pour afficher les tables
  *****************************************/
  public function lister($param)
  {
    switch($param)
    {
      case 'categories':   $data = DB::table('categories')->get();   return view('Espace_Direct.liste-categories')->with('data',$data);    break;
      case 'fournisseurs': $data = DB::table('fournisseurs')->get(); return view('Espace_Direct.liste-fournisseurs')->with('data',$data);  break;
      case 'articles':     $data = DB::table('articles')->get();     return view('Espace_Direct.liste-articles')->with('data',$data);      break;
      case 'marques':      $data = DB::table('marques')->get();      return view('Espace_Direct.liste-marques')->with('data',$data);      break;
      case 'magasins':     $data = DB::table('magasins')->get();     return view('Espace_Direct.liste-magasins')->with('data',$data);      break;
      default: return back()->withInput()->with('alert_warning','<strong>Erreur !!</strong>');      break;
    }
  }


  /******************************************
  Fonction pour effacer une ligne d'une table
  *******************************************/
  public function delete($p_table,$p_id)
  {
   try
   {
     switch ($p_table)
     {
       case 'categories':   Categorie::find($p_id)->delete();   return back()->withInput()->with('alert_success','La catégorie a été effacée avec succès');   break;
       case 'fournisseurs': fournisseur::find($p_id)->delete(); return back()->withInput()->with('alert_success','Le fournisseur a été effacé avec succès');  break;
       case 'articles':     Article::find($p_id)->delete();     return back()->withInput()->with('alert_success','L\'article a été effacé avec succès');      break;
       case 'magasins':     Magasin::find($p_id)->delete();     return back()->withInput()->with('alert_success','Le magasin a été effacé avec succès');      break;
       default:             return back()->withInput()->with('alert_danger','<strong>Erreur !!</strong> probleme dans: DirectController@delete');             break;
     }
   }
   catch(Exception $ex)
   {
     return back()->with('alert_danger','erreur!! <strong>'.$ex->getMessage().'</strong> ');
   }
  }

  /****************************************
  retourner la vue pour afficher les details
  *****************************************/
  public function info($p_table,$p_id)
  {
    switch($p_table)
    {
      case 'categories':    $item = Categorie::find($p_id);   return ( $item != null ? view('Espace_Direct.info-categorie')->with('data',$item) :   back()->withInput()->with('alert_warning','<strong>Erreur !!</strong> la catégorie choisie n\'existe pas') );   break;
      case 'fournisseurs':  $item = fournisseur::find($p_id); return ( $item != null ? view('Espace_Direct.info-fournisseur')->with('data',$item) : back()->withInput()->with('alert_warning','<strong>Erreur !!</strong> le fournisseur choisi n\'existe pas') );   break;
      case 'articles':      $item = Article::find($p_id);     return ( $item != null ? view('Espace_Direct.info-article')->with('data',$item) :     back()->withInput()->with('alert_warning','<strong>Erreur !!</strong> l\'article choisi n\'existe pas') );   break;
      case 'magasins':      $item = Magasin::find($p_id);     return ( $item != null ? view('Espace_Direct.info-magasin')->with('data',$item) :     back()->withInput()->with('alert_warning','<strong>Erreur !!</strong> le magasin choisi n\'existe pas') );   break;
      default: return back()->withInput()->with('alert_warning','<strong>Erreur !!</strong> Vous avez pris le mauvais chemin. ==> DirectController@info');      break;
    }
  }


  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  /********************************************************
    Valider L'ajout
  *********************************************************/
  public function submitAdd($param)
  {
   switch($param)
   {
     case 'magasin':        return $this->submitAddMagasin(); break;
     case 'fournisseur':    return $this->submitAddFournisseur(); break;
     case 'categorie':      return $this->submitAddCategorie(); break;
     case 'article':        return $this->submitAddArticle(); break;
     default: return back()->withInput()->with('alert_warning','<strong>Erreur !!</strong> Vous avez pris le mauvais chemin. ==> DirectController@submitAdd');      break;
   }
  }

  //Valider l'ajout de : Magasin
  public function submitAddMagasin()
  {
    if( request()->get('submit') == 'verifier' )
    {
      if( Exists('magasins', 'libelle', request()->get('libelle') )  )
        return redirect()->back()->withInput()->with('alert_warning','<strong>Alert !!</strong> Le magasin <i>'.request()->get('libelle').'</i> existe déjà');

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
  public function submitAddCategorie()
  {
    if( request()->get('submit') == 'verifier' )
    {

      if( request()->get('libelle')==null )
       return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur !!</strong> veuillez remplir le champ libelle');

      if( Exists('categories', 'libelle', request()->get('libelle') )  )
       return redirect()->back()->withInput()->with('alert_warning','<strong>Alert !!</strong> La catégorie <i>'.request()->get('libelle').'</i> existe déjà');

      if( request()->get('description')==null )
       return redirect()->back()->withInput()->with('alert_info','il est préférable de remplir le champs description aussi.');
      else
       return redirect()->back()->withInput()->with('alert_success','Rien à signaler, vous pouvez valider.');
    }
    else if( request()->get('submit') == 'valider' )
    {
      if( request()->get('libelle')==null )
       return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur !!</strong> veuillez remplir le champ libelle');

      $item = new Categorie;
      $item->libelle      = request()->get('libelle');
      $item->description  = request()->get('description');
      $item->save();
      return redirect()->back()->with('alert_success','La Categorie <strong>'.request()->get('libelle').'</strong> a bien été ajouté.');
    }
    else
    {
      return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur de Redirection</strong><br> from: DirectController@submitAdd (submitAddCategorie)');
    }
  }


  //Valider l'ajout de Fournisseur
  public function submitAddFournisseur()
  {
    if( request()->get('submit') == 'verifier' )
    {
      if( request()->get('libelle')==null || request()->get('code')==null )
       return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur !!</strong> veuillez remplir les champs Code et Libelle');

      if( Exists('fournisseurs', 'libelle', request()->get('libelle') )  )
        return redirect()->back()->withInput()->with('alert_warning','<strong>Alert !!</strong> Le Fournisseur <i>'.request()->get('libelle').'</i> existe déjà');

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
      return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur de Redirection</strong><br> from: DirectController@submitAdd (submitAddFournisseur)');
    }
  }

  //Valider l'ajout de : Magasin
  public function submitAddArticle()
  {
    if( request()->get('submit') == 'verifier' )
    {
      if( Exists('articles', 'designation_c', request()->get('designation_c') )  )
        return redirect()->back()->withInput()->with('alert_warning','<strong>Alert !!</strong> L\'article <i>'.request()->get('designation_c').'</i> existe déjà.');

      if( Exists('articles', 'num_article', request()->get('num_article') )  )
      {
        if( Exists('articles', 'code_barre', request()->get('code_barre') )  )
          return redirect()->back()->withInput()->with('alert_warning','<strong>Alert !!</strong> Le numero: <i>'.request()->get('num_article').'</i> et le code: <i>'.request()->get("code_barre").'</i> sont déjà utilisés pour un autre article.');
        else
          return redirect()->back()->withInput()->with('alert_warning','<strong>Alert !!</strong> Le numero: <i>'.request()->get('num_article').'</i> est deja utilise pour un autre article.');
      }

      if( Exists('articles', 'code_barre', request()->get('code_barre') )  )
        return redirect()->back()->withInput()->with('alert_warning','<strong>Alert !!</strong> Le numero: <i>'.request()->get('num_article').'</i> est deja utilise pour un autre article.');

      if( request()->get('prix')==null || request()->get('taille')==null )
        return redirect()->back()->withInput()->with('alert_info','il est préférable de remplir tous les champs.');

      else
       return redirect()->back()->withInput()->with('alert_success','Rien à signaler, vous pouvez valider');
    }
    else if( request()->get('submit') == 'valider' )
    {
      $item = new Article;
      $item->id_categorie   = request()->get('id_categorie');
      $item->id_fournisseur = request()->get('id_fournisseur');
      $item->num_article    = request()->get('num_article');
      $item->code_barre     = request()->get('code_barre');
      $item->designation_c  = request()->get('designation_c');
      $item->designation_l  = request()->get('designation_l');
      $item->taille         = request()->get('taille');
      $item->sexe           = request()->get('sexe');
      $item->couleur        = request()->get('couleur');
      $item->prix           = request()->get('prix');

      try
      {
        $item->save();
      }
      catch(Exception $ex){ return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur! </strong> une erreur s\'est produite lors de l\'ajout de l\'article.<br>Message d\'erreur: '.$ex->getMessage() ); }

      return redirect()->back()->with('alert_success','L\'article <strong>'.request()->get('designation_c').'</strong> a bien été ajouté.');
    }
    else
    {
      return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur de Redirection</strong><br> from: DirectController@submitAdd (submitAddArticle)');
    }
  }

  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@



  /********************************************************
    Valider L'ajout
  *********************************************************/
  public function submitUpdate($param)
  {
   switch($param)
   {
     case 'magasin':        return $this->submitUpdateMagasin(); break;
     case 'marque':         return $this->submitUpdateMarque(); break;
     case 'fournisseur':    return $this->submitUpdateFournisseur(); break;
     case 'categorie':      return $this->submitUpdateCategorie(); break;
     case 'article':        return $this->submitUpdateArticle(); break;
     default: return back()->withInput()->with('alert_warning','<strong>Erreur !!</strong> Vous avez pris le mauvais chemin.');      break;
   }
  }


  //Valider la modification d un article
  public function submitUpdateArticle()
  {
      $item = Article::find( request()->get('id_article') );
      $item->update([
        'id_categorie'    => request()->get('id_categorie'),
        'id_fournisseur'  => request()->get('id_fournisseur'),
        'num_article'     => request()->get('num_article'),
        'code_barre'      => request()->get('code_barre'),
        'designation_c'   => request()->get('designation_c'),
        'designation_l'   => request()->get('designation_l'),
        'taille'          => request()->get('taille'),
        'couleur'         => request()->get('couleur'),
        'sexe'            => request()->get('sexe'),
        'prix'            => request()->get('prix')
      ]);
     return redirect()->route('direct.info',['p_table' => 'articles', 'id' => request()->get('id_article') ])->with('alert_success','Modification de l\'article reussi.');
  }

  //Valider la modification d un Categorie
  public function submitUpdateCategorie()
  {
      $item = Categorie::find( request()->get('id_categorie') );
      $item->update([
        'libelle'     => request()->get('libelle'),
        'description' => request()->get('description')
      ]);
     return redirect()->route('direct.info',['p_table' => 'categories', 'id' => request()->get('id_categorie') ])->with('alert_success','Modification du fournisseur reussi.');
  }

  //Valider la modification d un fournisseur
  public function submitUpdateFournisseur()
  {
      $item = Fournisseur::find( request()->get('id_fournisseur') );
      $item->update([
        'code'        => request()->get('code'),
        'libelle'     => request()->get('libelle'),
        'agent'       => request()->get('agent'),
        'email'       => request()->get('email'),
        'telephone'   => request()->get('telephone'),
        'fax'         => request()->get('fax'),
        'description' => request()->get('description')
      ]);
     return redirect()->route('direct.info',['p_table' => 'fournisseurs', 'id' => request()->get('id_fournisseur') ])->with('alert_success','Modification du fournisseur reussi.');
  }

  //Valider la modification d un Magasin
  public function submitUpdateMagasin()
  {
      $item = Magasin::find( request()->get('id_magasin') );
      $item->update([
        'libelle'     => request()->get('libelle'),
        'ville'       => request()->get('ville'),
        'agent'       => request()->get('agent'),
        'email'       => request()->get('email'),
        'telephone'   => request()->get('telephone'),
        'adresse'     => request()->get('adresse'),
        'description' => request()->get('description')
      ]);
     return redirect()->route('direct.info',['p_tables' => 'magasins', 'id' => request()->get('id_magasin') ])->with('alert_success','Modification du fournisseur reussi.');
  }





}
