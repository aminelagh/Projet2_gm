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

class DirectController extends Controller
{
  public function home()
  {
    return view('Espace_Direct.dashboard');
  }

  //affiche tt les formulaire d'ajout de la partie Direction
  public function addForm($param)
  {
    if($param == 'article')
    {
      $categories = DB::table('categories')->get();
      $fournisseurs = DB::table('fournisseurs')->get();
    }
    switch($param)
    {
      case 'categorie':   return view('Espace_Direct.add-categorie-form'); break;
      case 'fournisseur': return view('Espace_Direct.add-fournisseur-form'); break;
      case 'article':     return view('Espace_Direct.add-article-form')->with(['fournisseurs' => $fournisseurs , 'categories' => $categories]); break;
    }

    //$magasins = DB::table('magasins')->get();
    //$roles = DB::table('roles')->get();
    //return view('Espace_Admin.add-user-form')->with([ 'magasins' => $magasins, 'roles' => $roles ]);
  }


    /*********************
     Valider L'ajout des categories
     ***********************/
     public function submitAddCategorie(Request $request)
     {
       //creation d'une Cate a partir des donnees du formulaire:
       $model = new Categorie();
       $model->libelle = $request->libelle;
       $model->description = $request->description;

       $model->save();
       return redirect()->route('direct.addForm',['param' => 'categorie'])->with('msgAjoutReussi','creation de la categorie: "<strong>'.$request->libelle.'</strong>"  reussi');
     }

     /*********************
      Valider L'ajout des fournisseurs
      ***********************/
      public function submitAddFournisseur(Request $request)
      {
        //creation d'une Cate a partir des donnees du formulaire:
        if( $request->submit == "verifier" )
        {
          if( $request->telephone=='' || $request->code=='' || $request->libelle=='' )
            return redirect()->route('direct.addForm',['param' => 'fournisseur'])->withInput($request->only('code','libelle','telephone','fax','description') )->with('alert_warning','code et/ou libelle et/ou telephone sont vide');

          if( DB::table('fournisseurs')->where('libelle',$request->libelle)->first() )
            return redirect()->route('direct.addForm',['param' => 'fournisseur'])->withInput($request->only('code','libelle','telephone','fax','description') )->with('alert_warning','<strong>'.$request->libelle.'</strong> exist deja.');

          if( DB::table('fournisseurs')->where('code',$request->code)->first() )
            return redirect()->route('direct.addForm',['param' => 'fournisseur'])->withInput($request->only('code','libelle','telephone','fax','description') )->with('alert_warning','<strong>'.$request->code.'</strong> est deja utilisé pour un autre fournisseur.');

          if( DB::table('fournisseurs')->where('code',$request->telephone)->first() )
            return redirect()->route('direct.addForm',['param' => 'fournisseur'])->withInput($request->only('code','libelle','telephone','fax','description') )->with('alert_warning','<strong>'.$request->telephone.'</strong> est deja utilisé pour un autre fournisseur.');

          else
            return redirect()->route('direct.addForm',['param' => 'fournisseur'])->withInput($request->only('code','libelle','telephone','fax','description') )->with('alert_success','vous pouvez valider');

        }
        else if( $request->submit == "valider" )
        {
          $model = new Fournisseur();
          $model->code = $request->code;
          $model->libelle = $request->libelle;
          $model->description = $request->description;
          $model->telephone = $request->telephone;
          $model->fax = $request->fax;

          try
          {
            $model->save();
          }
          catch (Exception $e)
          {
            return redirect()->route('direct.addForm',['param' => 'fournisseur'])->with('alert_danger','erreur!! ajout de "<strong>'.$request->libelle.'</strong>"  echoue');
          }
          return redirect()->route('direct.addForm',['param' => 'fournisseur'])->with('alert_success','creation du Fournisseur: "<strong>'.$request->libelle.'</strong>"  reussi');
        }


      }




     //permet de retourner la vue qui contient le formulaire d'ajout
     public function listerUsersOrder($orderby)
     {
       $data = DB::table('users')->orderBy($orderby)->get();
       return view('Espace_Direct.liste-users')->with('data',$data);
     }

      //permet de retourner la vue qui contient le formulaire d'ajout
      public function lister($param)
      {
        switch($param)
        {
          case 'categorie':   $data = DB::table('categories')->get(); return view('Espace_Direct.liste-categories')->with('data',$data); break;
          case 'fournisseur': $data = DB::table('fournisseurs')->get(); return view('Espace_Direct.liste-fournisseurs')->with('data',$data); break;
        }
      }


      /*
      Fonction pour effacer une ligne d'une table
      */
      public function delete($p_table,$p_id)
      {
        try
        {
          switch ($p_table)
          {
            case 'categories':    DB::table('categories')->where('id_categorie', $p_id)->delete();      return back()->withInput()->with('alert_success','Categorie with id: <strong>'.$p_id.'</strong> was deleted successfully'); break;
            case 'fournisseurs':  DB::table('fournisseurs')->where('id_fournisseur', $p_id)->delete();  return back()->withInput()->with('alert_success','Fournisseur with id: <strong>'.$p_id.'</strong> was deleted successfully');; break;
            case 'articles':      DB::table('articles')->where('id_article', $p_id)->delete();          return back()->withInput()->with('alert_success','Article with id: <strong>'.$p_id.'</strong> was deleted successfully');; break;
          }
        }
        catch(\Exception $ex)
        {
          return back()->with('alert_danger','erreur!! <strong>'.$ex->getMessage().'</strong> ');
        }
      }











  /*********************
   Valider L'ajout des Users
   ***********************/
   public function submitAddUser(Request $request)
   {
     //creation d'un Directeur a partir des donnees du formulaire:
     $user = new User();
     $user->id_role = $request->id_role;
     $user->id_magasin = $request->id_magasin;
     $user->nom = $request->nom;
     $user->prenom = $request->prenom;
     $user->ville = $request->ville;
     $user->telephone = $request->telephone;
     $user->email = $request->email;
     $user->password = Hash::make( $request->password );
     $user->description = $request->description;

     //si l'email exist deja alors revenir au formulaire avec les donnees du formulaire et un message d'erreur
     if( EmailExist( $request->email , 'users' )  )
      return redirect()->route('admin.addUser')->withInput($request->only('nom','prenom','ville','description') )->with('msgErreur','<strong>Erreur: </strong>  "'.$request->email.'" est deja utilisé');

     //si le mot de passe et trop court:
     if( strlen($request->password)<7 )
      return redirect()->route('admin.addUser')->withInput($request->only('nom','prenom','ville','email','description') )->with('msgErreur','<strong>Erreur: </strong> Mot de Passe trop court.');

     $user->save();
     //dump( $user );
     return redirect()->route('admin.addUser')->with('msgAjoutReussi','ajout de  "<strong>'.$request->email.'</strong>"  Reussi');
   }
}
