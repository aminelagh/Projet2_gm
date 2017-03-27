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
    if($param == 'article')
    {
      $categories   = DB::table('categories')->get();
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
       $model->libelle      = $request->libelle;
       $model->description  = $request->description;

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
          $model->code        = $request->code;
          $model->libelle     = $request->libelle;
          $model->description = $request->description;
          $model->telephone   = $request->telephone;
          $model->fax         = $request->fax;

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

      /*********************
       Valider L'ajout des Articles
       ***********************/
       public function submitAddArticle(Request $request)
       {
         //si appui sur bouton verifier
         if( $request->submit == "verifier" )
         {
           if( strlen($request->designation) >= 255 )
             return redirect()->route('direct.addForm',['param' => 'article'])->withInput()->with('alert_danger',"<strong>Erreur !!</strong> La désignation de l'article ne doit pas dépasser 255 caractères.");
           if( $request->prix == 0 )
             return redirect()->route('direct.addForm',['param' => 'article'])->withInput()->with('alert_info',"Il semblerait  que vous avez oublié de saisir le prix de cet article");

           if( DB::table('articles')->where('designation',$request->designation)->first() )
             return redirect()->route('direct.addForm',['param' => 'article'])->withInput()->with('alert_warning','<strong>'.$request->designation.'</strong> exist deja.');

           if( DB::table('articles')->where('num_article',$request->num_article)->first() )
             return redirect()->route('direct.addForm',['param' => 'article'])->withInput()->with('alert_warning','Numero Article: <strong>'.$request->num_article.'</strong> est deja utilisé pour un autre article.');

           if( DB::table('articles')->where('code_barre',$request->code_barre)->first() )
             return redirect()->route('direct.addForm',['param' => 'article'])->withInput()->with('alert_warning','Code a Barres: <strong>'.$request->code_barre.'</strong> est deja utilisé pour un autre article.');

           if( $request->id_fournisseur == 0 )
             return redirect()->route('direct.addForm',['param' => 'article'])->withInput()->with('alert_info',"vous n'avez pas choisi de fournisseur pour votre produit.");
           if( $request->id_categorie == 0 )
             return redirect()->route('direct.addForm',['param' => 'article'])->withInput()->with('alert_info',"vous n'avez pas choisi de categorie pour votre produit.");
           else
             return redirect()->route('direct.addForm',['param' => 'article'])->withInput()->with('alert_success','Verification reussit');

         }
         else if( $request->submit == "valider" )
         {
           $model = new Article();
           $model->id_categorie   = $request->id_categorie;
           $model->id_fournisseur = $request->id_fournisseur;
           $model->num_article    = $request->num_article;
           $model->code_barre     = $request->code_barre;
           $model->designation    = $request->designation;
           $model->taille         = $request->taille;
           $model->sexe           = $request->sexe;
           $model->prix           = $request->prix;
           $model->description    = $request->description;

           //test pour le champ couleur:
           if( $request->couleur_name != null )
           {
             $model->couleur = $request->couleur_name;
           }
           else
           {
             $model->couleur = $request->couleur_value;
           }

           try
           {
             $model->save();
             return redirect()->route('direct.addForm',['param' => 'article'])->with('alert_success',"Création de l'article <strong>".$request->designation."</strong>  reussi.");
           }
           catch (Exception $exception)
           {
             return redirect()->route('direct.addForm',['param' => 'article'])->withInput()->with('alert_danger',"<strong>Erreur !</<strong> l'ajout de l'article: <strong>".$request->designation."</strong>  a échoué:<br/>Message d'erreur: ".$exception->getMessage());
           }
         }
       }





     //permet de retourner la vue qui contient le formulaire d'ajout
     public function listerUsersOrder($orderby)
     {
       $data = DB::table('users')->orderBy($orderby)->get();
       return view('Espace_Direct.liste-users')->with('data',$data);
     }

     /*
     retourner la vue pour afficher les tables
     */
      public function lister($param)
      {
        switch($param)
        {
          case 'categorie':   $data = DB::table('categories')->get();   return view('Espace_Direct.liste-categories')->with('data',$data);    break;
          case 'fournisseur': $data = DB::table('fournisseurs')->get(); return view('Espace_Direct.liste-fournisseurs')->with('data',$data);  break;
          case 'article':     $data = DB::table('articles')->get();     return view('Espace_Direct.liste-articles')->with('data',$data);      break;
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



}
