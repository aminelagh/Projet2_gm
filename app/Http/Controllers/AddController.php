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
use App\Models\Promotion;
use \Exception;

class AddController extends Controller
{

	/********************************************************
	Afficher le formulaire d'ajout pour tt les tables
	*********************************************************/
	public function addForm($p_table)
	{
		switch($p_table)
		{
			case 'users':					return view('Espace_Admin.add-user-form')->with([ 'data' => User::all(), 'magasins' => Magasin::all(), 'roles' => Role::all() ]); break;
			case 'categories':    return view('Espace_Direct.add-categorie-form')->withData( Categorie::all() );      break;
			case 'fournisseurs':  return view('Espace_Direct.add-fournisseur-form')->withData( Fournisseur::all() );  break;
			case 'magasins':      return view('Espace_Direct.add-magasin-form')->withData( Magasin::all() );          break;
			case 'articles':      return view('Espace_Direct.add-article-form')->with(['data' => Article::all() , 'fournisseurs' => Fournisseur::all() , 'categories' => Categorie::all() ]); 				break;
			case 'promotions':    return view('Espace_Direct.add-promotions-form')->with(['articles' => Article::all() , 'fournisseurs' => Fournisseur::all() , 'categories' => Categorie::all(), 'magasins' => Magasin::all() ]); 	break;
			default: return redirect()->back()->withInput()->with('alert_warning','Le formulaire d\'ajout choisi n\'existe pas.');      break;
		}
	}

	/********************************************************
	Valider L'ajout: Fonction de principale
	*********************************************************/
	public function submitAdd($p_table)
	{
	 switch($p_table)
	 {
		 case 'magasins':     return $this->submitAddMagasin(); 		break;
		 case 'fournisseurs': return $this->submitAddFournisseur(); break;
		 case 'categories':   return $this->submitAddCategorie(); 	break;
		 case 'articles':     return $this->submitAddArticle(); 		break;
		 case 'stocks':       return $this->submitAddStock(); 			break;
		 case 'users':				return $this->submitAddUser(); 				break;
		 case 'promotions':		return $this->submitAddPromotions(); 	break;
		 default: return redirect()->back()->withInput()->with('alert_warning','<strong>Erreur !!</strong> Vous avez pris le mauvais chemin. ==> AddController@submitAdd');      break;
	 }
	}

	//Valider l'ajout d un utilisateur
	public function submitAddUser()
	{
		//creation d'un Directeur a partir des donnees du formulaire:
		$item = new User();
		$item->id_role     = request()->get('id_role');
		$item->id_magasin  = request()->get('id_magasin');
		$item->nom         = request()->get('nom');
		$item->prenom      = request()->get('prenom');
		$item->ville       = request()->get('ville');
		$item->telephone   = request()->get('telephone');
		$item->email       = request()->get('email');
		$item->password    = Hash::make( request()->get('password') );
		$item->description = request()->get('description');

		//si l'email exist deja alors revenir au formulaire avec les donnees du formulaire et un message d'erreur
		if( EmailExist( request()->get('email') , 'users' )  )
			return redirect()->back()->withInput()->with('alert_danger',"<li><i>".request()->get('email')."</i> est deja utilisé.");

		//si le mot de passe et trop court:
		if( strlen(request()->get('password'))<7 )
			return back()->withInput()->with('alert_danger',"<li>Mot de Passe trop court.");

			try
			{
				$item->save();
			}catch(Exception $ex)
			{
				return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur !!</strong> l\'out de '.request()->get('email').' a echoue. <br> message d\'erreur: '.$ex->getMessage().'');
			}

		return redirect()->back()->with('alert_success','ajout de  "<strong>'.request()->get('email').'</strong>"  Reussi');
	}

	//Valider l'ajout de : Magasin
	public function submitAddMagasin()
	{
		//if( Exists('magasins', 'libelle', request()->get('libelle') )  )			return redirect()->back()->withInput()->with('alert_warning','<strong>Alert !!</strong> Le magasin <i>'.request()->get('libelle').'</i> existe déjà');
		//if( request()->get('email')==null || request()->get('agent')==null || request()->get('ville')==null || request()->get('telephone')==null || request()->get('adresse')==null  )			return redirect()->back()->withInput()->with('alert_info','il est préférable de remplir tous les champs.');
		//if( Exists('magasins', 'libelle', request()->get('libelle')) )			return redirect()->back()->withInput()->with('alert_warning','Le magasin <strong>'.request()->get('libelle').'</strong> exist deja.');

		$item = new Magasin;
		$item->libelle      = request()->get('libelle');
		$item->email        = request()->get('email');
		$item->agent        = request()->get('agent');
		$item->ville        = request()->get('ville');
		$item->telephone    = request()->get('telephone');
		$item->adresse      = request()->get('adresse');
		$item->description  = request()->get('description');
		try
		{
			$item->save();
		}catch(Exception $e)
		{
			return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur !!</strong> l\'out du magasin: '.request()->get('libelle').' a echoue. <br> message d\'erreur: '.$ex->getMessage().'');
		}
		return redirect()->back()->with('alert_success','Le Magasin <strong>'.request()->get('libelle').'</strong> a bien été ajouté.');

	}

	//Valider l'ajout de : Categorie
	public function submitAddCategorie()
	{
		if( request()->get('libelle')==null )
			 return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur !!</strong> veuillez remplir le champ libelle');
		if( Exists('categories', 'libelle', request()->get('libelle') )  )
			 return redirect()->back()->withInput()->with('alert_warning','<strong>Alert !!</strong> La catégorie <i>'.request()->get('libelle').'</i> existe déjà');
		if( request()->get('libelle')==null )
			 return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur !!</strong> veuillez remplir le champ libelle');

		$item = new Categorie;
		$item->libelle      = request()->get('libelle');
		$item->description  = request()->get('description');
		try
		{
			$item->save();
		}catch(Exception $ex)
		{
			return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur !!</strong> l\'out de '.request()->get('libelle').' a echoue. <br> message d\'erreur: '.$ex->getMessage().'');
		}
		return redirect()->back()->with('alert_success','La Categorie <strong>'.request()->get('libelle').'</strong> a bien été ajouté.');
	}

	//Valider l'ajout de Fournisseur
	public function submitAddFournisseur()
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
		try
		{
			$item->save();
		}catch(Exception $ex)
		{
			return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur !!</strong> l\'out du fournisseur: '.request()->get('libelle').' a echoue. <br> message d\'erreur: '.$ex->getMessage().'');
		}
		return redirect()->back()->with('alert_success','Le Fournisseur <strong>'.request()->get('code').': '.request()->get('libelle').'</strong> a bien été ajouté.');

	}

	//Valider l'ajout de : Magasin
	public function submitAddArticle()
	{
		$alerts1 = "";		$alerts2 = "";
		$error1 = false;    $error2 = false;

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
		$item->prix_achat     = request()->get('prix_achat');
		$item->prix_vente     = request()->get('prix_vente');

		if( request()->has('force') && request()->get('force')=="true" )
		{
			if( Exists('articles', 'designation_c', request()->get('designation_c') )  ) {
                $alerts1 = $alerts1."<li>L\'article <i>".request()->get('designation_c')."</i> existe déjà.";
                $error1 = true;
            }
			if( Exists('articles', 'num_article', request()->get('num_article') )  ){
                $alerts1 = $alerts1."<li>Le numero: <i>".request()->get('num_article')."</i> est deja utilise pour un autre article.";
                $error1 = true;
            }
			try
			{
				$item->save();
			}
			catch(Exception $ex){ return redirect()->back()->withInput()->with('alert_danger','<li>Une erreur s\'est produite lors de l\'ajout de l\'article.<br>Message d\'erreur: '.$ex->getMessage() ); }

            if($error1)
			    redirect()->back()->with('alert-info',$alerts1);

			return redirect()->back()->with('alert_success','L\'article <strong>'.request()->get('designation_c').'</strong> a bien été ajouté.');
		}
		else
		{
			if( Exists('articles', 'designation_c', request()->get('designation_c') )  ) {
			    $alerts1 = $alerts1."<li>L'article <i>".request()->get('designation_c')."</i> existe déjà.";
			    $error1 = true;
            }

			if( Exists('articles', 'num_article', request()->get('num_article') )  ) {
                $alerts1 = $alerts1."<li>Le numero: <i>".request()->get('num_article')."</i> est deja utilisé pour un autre article.";
                $error1 = true;
            }
			if( Exists('articles', 'code_barre', request()->get('code_barre') )  ){
			    $alerts1 = $alerts1."<li>Le code: <i>".request()->get('code')."</i> est deja utilisé pour un autre article.";
                $error1 = true;
            }
			if( request()->get('prix_vente')==null ) {
			    $alerts2 = $alerts2."<li>Veuillez remplir le champ: <i>Prix de vente</i>";
                $error2 = true;
            }
			if( request()->get('prix_achat')==null ) {
			    $alerts2 = $alerts2."<li>Veuillez remplir le champ: <i>Prix d'achat</i>";
                $error2 = true;
            }

			if( request()->get('taille')==null ) {
			    $alerts2 = $alerts2."<li>Veuillez remplir le champ: <i>Taille</i>";
                $error2 = true;
            }
			if( request()->get('couleur')==null ) {
			    $alerts2 = $alerts2."<li>Veuillez remplir le champ: <i>Couleur</i>";
                $error2 = true;
            }

			redirect()->back()->withInput()->with('alert_info',$alerts1);
			redirect()->back()->withInput()->with('alert_warning',$alerts2);

			if( $error1 || $error2)
			    return redirect()->back()->withInput()->with('alert_success','vous pouvez forcer l\'ajout en cochant la case en dessous du formulaire.');

			try
			{
				$item->save();
			}
			catch(Exception $ex){ return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur! </strong> une erreur s\'est produite lors de l\'ajout de l\'article.<br>Message d\'erreur: '.$ex->getMessage() ); }

			return redirect()->back()->with('alert_success','L\'article <strong>'.request()->get('designation_c').'</strong> a bien été ajouté.');
		}
	}

	//Valider la creation des promotions
	public function submitAddPromotions()
	{
		dump(request());
		return 'a';
		//id du magasin
		$id_magasin   	= request()->get('id_magasin');

		//array des element du formulaire
		$id_article   	= request()->get('id_article');
		$designation_c	= request()->get('designation_c');
		$quantite     	= request()->get('quantite');
		$quantite_min 	= request()->get('quantite_min');
		$quantite_max 	= request()->get('quantite_max');

		$alert1 = "";
		$alert2 = "";
		$error1 = false;
		$error2 = false;
		$nbre_articles = 0;

		for( $i=1; $i<=count($id_article) ; $i++ )
		{
			if( $quantite[$i] == null ) continue;

			if( $quantite_min[$i]>$quantite_max[$i] )
			{
				$alert1 = $alert1."<li><b>".$designation_c[$i]."</b>: Quantite min superieur a la quantité max.";
				$error1 = true;
			}

			if( $quantite[$i] != null && ($quantite_min[$i] == null || $quantite_max[$i] == null) )
			{
				$alert1 = $alert1."<li> ".$i.": <b>".$designation_c[$i]."</b>: vous avez oublier de specifier la quantite min et/ou la quantite max.";
				$error1 = true;
			}

			if( $quantite[$i]!=null && $quantite_min[$i]<=$quantite_max[$i] )
			{
				$item = new Stock;
				$item->id_magasin    = $id_magasin;
				$item->id_article    = $id_article[$i];
				$item->quantite      = $quantite[$i];
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

		return redirect()->back()->with('alert_success','Creation du stock reussit. nbre articles: '.$nbre_articles);
	}












  //permet de retourner la vue qui contient le formulaire de modification du mot de passe
  public function updatePasswordFormUser($id)
  {
		$magasins = DB::table('magasins')->get();
		$roles = DB::table('roles')->get();
		$data = DB::table('users')->where('id_user',$id)->first();

		//si l'utilisateur n'existe pas, redirect vers la page precedente avec un message d'erreur
		if($data==null)
	 		return redirect()->back()->with('alert_danger','<strong>Erreur !!</strong> l\'utilisateur que vous avez choisi n\'existe pas, veuillez actualiser la page.');
		else
			return view('Espace_Admin.updatePassword-user-form')->with([ 'data' => $data ,'magasins' => $magasins, 'roles' => $roles ]);
  }


	/*********************
	Valider La modification des Users
	***********************/
	public function submitUpdateUser()
	{
	  if( EmailExist_2( request()->get('email') , request()->get('id_user') )  )
		return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur: </strong>  "'.request()->get('email').'" est deja utilisé pour un autre utilisateur.');
	  else
		$user = User::find(request()->get('id_user'));
		$user->update([
		  'id_role'     => request()->get('id_role'),
		  'id_magasin'  => request()->get('id_magasin'),
		  'nom'         => request()->get('nom'),
		  'prenom'      => request()->get('prenom'),
		  'ville'       => request()->get('ville'),
		  'telephone'   => request()->get('telephone'),
		  'email'       => request()->get('email'),
		  'description' => request()->get('description'),
		]);

	   return redirect()->route('admin.infoUser',['id' => request()->get('id_user') ])->with('alert_success','Modification de l\'utilisateur reussi.');
	}

	/*********************
	Valider La modification du mot de passe
	***********************/
	public function submitUpdatePasswordUser()
	{

	  if( strlen(request()->get('password'))<8 )
		return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur: </strong> le mot de passe doit contenir, au moins, 7 caractères.');

	  $user = User::find(request()->get('id_user'));
	  $user->update([
		  'password'     => Hash::make( request()->get('password')  )
	  ]);

	  return redirect()->route('admin.infoUser',['id' => request()->get('id_user') ])->with('alert_success','Modification du mot de passe de l\'utilisateur reussi.');
	}




}
