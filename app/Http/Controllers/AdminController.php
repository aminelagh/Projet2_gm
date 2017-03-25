<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Magasin;

class AdminController extends Controller
{

    public function home()
    {
      return view('Espace_Admin.dashboard');
    }

    //permet de retourner la vue qui contient le formulaire d'ajout
    public function addFormUser()
    {
      $magasins = DB::table('magasins')->get();
      $roles = DB::table('roles')->get();
      return view('Espace_Admin.add-user-form')->with([ 'magasins' => $magasins, 'roles' => $roles ]);
    }

    //permet de retourner la vue qui contient le formulaire d'ajout
     public function listerUsersOrder($orderby)
     {
       $data = DB::table('users')->orderBy($orderby)->get();
       return view('Espace_Admin.liste-users')->with('data',$data);
     }

     //permet de retourner la vue qui contient le formulaire d'ajout
      public function listerUsers()
      {
        $data = DB::table('users')->get();
        return view('Espace_Admin.liste-users')->with('data',$data);
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
