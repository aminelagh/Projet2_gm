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
use Carbon\Carbon;
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
		 case 'magasins':       return $this->submitAddMagasin(); 		break;
		 case 'fournisseurs':   return $this->submitAddFournisseur();   break;
		 case 'categories':     return $this->submitAddCategorie(); 	break;
		 case 'articles':       return $this->submitAddArticle(); 		break;
		 case 'stocks':         return $this->submitAddStock(); 		break;
		 case 'users':		    return $this->submitAddUser(); 			break;
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
			return redirect()->back()->withInput()->with('alert_danger','<strong>Erreur !!</strong> l\'out du magasin: '.request()->get('libelle').' a echoue. <br> message d\'erreur: '.$e->getMessage().'');
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
			    return redirect()->back()->withInput()->with('alert_success',"vous pouvez forcer l'ajout en cochant la case en dessous du formulaire.");

			try
			{
				$item->save();
			}
			catch(Exception $ex){ return redirect()->back()->withInput()->with('alert_danger',"<strong>Erreur! </strong> une erreur s'est produite lors de l'ajout de l'article.<br>Message d'erreur: ".$ex->getMessage() ); }

			return redirect()->back()->with('alert_success','L\'article <strong>'.request()->get('designation_c').'</strong> a bien été ajouté.');
		}
	}

	//Valider la creation des promotions
	public function submitAddPromotions()
	{

		$id_article   	= request()->get('id_article');
        $id_magasin   	= request()->get('id_magasin');
		//$designation_c	= request()->get('designation_c');
        $taux     	    = request()->get('taux');
        $date_debut     = request()->get('date_debut');
        $date_fin     	= request()->get('date_fin');

		$alert1 = "";		$alert2 = "";
		$error1 = false;	$error2 = false;
		$nbre_articles = 0;

		for( $i=1; $i<=count($id_article) ; $i++ )
		{
			if( $taux[$i] == 0 || $taux[$i] == null || $date_debut[$i] == null  || $date_fin[$i] == null || $id_magasin[$i] == 0  ) continue;

            $dd = Carbon::createFromFormat('d-m-Y', date('d-m-Y', strtotime($date_debut[$i])));
            $df = Carbon::createFromFormat('d-m-Y', date('d-m-Y', strtotime($date_fin[$i])));

            //echo "M: ".$id_magasin[$i]." - T: ".$taux[$i]." - DD: ".$date_debut[$i]." - DF: ".$date_fin[$i]."<br>";
            //echo $dd->year."  ".$df->year."<br>";            echo $dd->month."  ".$df->month."<br>";            echo $dd->day."  ".$df->day."<hr>";

            //skip if EndDate < BeginDate
            if( $dd->year > $df->year ) continue;
            elseif( $dd->month > $df->month ) continue;
            elseif( $dd->day > $df->day ) continue;

            $item = new Promotion;
			$item->id_article   = $id_article[$i];
            $item->id_magasin   = $id_magasin[$i];
			$item->taux         = $taux[$i];
			$item->date_debut   = $date_debut[$i];
			$item->date_fin     = $date_fin[$i];
			$item->active       = true;

            try
			{
				$item->save();
				$nbre_articles++;
			}
			catch (Exception $e) { $error2 = true; $alert2 = $alert2."<li>Erreur de l'ajout de l'article numero ".$i.": <br>Message d'erreur: ".$e->getMessage();}

		}

		if($error1)
			back()->withInput()->with('alert_warning',$alert1);
		if($error2)
			back()->withInput()->with('alert_danger',$alert2);

		return redirect()->back()->with('alert_success','Creation des promotions reussite. nbre articles: '.$nbre_articles);
	}
















}
