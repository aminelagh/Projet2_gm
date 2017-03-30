<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Models\User;
use App\Models\Article;
use App\Models\Categorie;
use App\Models\Role;
use App\Models\Magasin;
use Illuminate\Http\Request;
use Carbon\Carbon;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index',function(){ return view('index'); });

//Route pour generer des PDF
Route::get('print/{param}','PDFController@imprimer')->name('print');


/*
Routes pour l espace Admin
*/
//home --> Dashboard
Route::get('/admin','AdminController@home')->name('admin.home');

//afficher le formulaire d'ajout et le valider
Route::get('/admin/addUser','AdminController@addFormUser')->name('admin.addUser');
Route::post('/admin/submitAddUser','AdminController@submitAddUser')->name('admin.submitAddUser');

//afficher le formulaire de modification et le valider
Route::get('/admin/updateUser/{id}','AdminController@updateFormUser')->name('admin.updateUser');
Route::post('/admin/submitUpdateUser','AdminController@submitUpdateUser')->name('admin.submitUpdateUser');

//lister les utlisateurs & trier les users
Route::get('/admin/lister','AdminController@listerUsers')->name('admin.lister');
Route::get('/admin/lister/{orderby}','AdminController@listerUsersOrder')->name('admin.listerOrder');

//afficher le profile d un user:
Route::get('/admin/infoUser/{id}','AdminController@infoUser')->name('admin.infoUser');

//Route::get('/admin/listerP','AdminController@listerUsersPagination')->name('admin.listerP');    //Lister avec filtre et pagination
//Route::post('/admin/listerP','AdminController@listerUsersPagination')->name('admin.listerP');   //Filtrer






/*
Routes pour l espace Direct
*/
//home --> Dashboard
Route::get('/direct','DirectController@home')->name('direct.home');
Route::get('/direct/add/{param}','DirectController@addForm')->name('direct.addForm');  //afficher le formulaire d'ajout

// Submit Form
Route::post('/direct/submitAddCategorie','DirectController@submitAddCategorie')->name('direct.submitAddCategorie');
Route::post('/direct/submitAddFournisseur','DirectController@submitAddFournisseur')->name('direct.submitAddFournisseur');
Route::post('/direct/submitAddArticle','DirectController@submitAddArticle')->name('direct.submitAddArticle');

Route::get('/direct/lister/{param}','DirectController@lister')->name('direct.lister');  //afficher le formulaire d'ajout

Route::get('/direct/delete/{p_table}/{p_id}','DirectController@delete')->name('direct.delete');  //afficher le formulaire d'ajout



/*
Route::get('/admin/add/{param}','AdminController@addForm')->name('admin.addForm');  //afficher le formulaire d'ajout
Route::post('/admin/submitAddDirect','AdminController@submitAddDirect')->name('admin.submitAddDirect'); //submit formulaire d'ajout
Route::post('/admin/submitAddMagas','AdminController@submitAddMagas')->name('admin.submitAddMagas'); //submit formulaire d'ajout
Route::post('/admin/submitAddMagas','AdminController@submitAddVend')->name('admin.submitAddVend'); //submit formulaire d'ajout
Route::post('/admin/submitAddRole','AdminController@submitAddRole')->name('admin.submitAddRole'); //submit formulaire d'ajout

Route::get('/lister/{param}','AdminController@lister')->name('admin.lister');  //afficher le formulaire d'ajout


/*
//admin routes
Route::prefix('/admin')->group( function()
{
  Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login'); //afficher le formulaire d'authetification
  Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit'); //submit les donnees du formulaire d'authentification
  Route::get('/', 'AdminController@index')->name('admin.dashboard');                    //ouvrir le Dashboard de l'admin
  Route::get('/logout', 'AdminController@logout')->name('admin.logout');                //LogOut Admin


  Route::get('/add/{param}','AdminController@addForm')->name('admin.addForm');  //afficher le formulaire d'ajout

  Route::post('/submitAddDirect','AdminController@submitAddDirect')->name('admin.submitAddDirect'); //submit formulaire d'ajout
  Route::post('/submitAddMagas','AdminController@submitAddMagas')->name('admin.submitAddMagas'); //submit formulaire d'ajout
  Route::post('/submitAddMagas','AdminController@submitAddVend')->name('admin.submitAddVend'); //submit formulaire d'ajout

  Route::get('/lister/{param}','AdminController@lister')->name('admin.lister');  //afficher le formulaire d'ajout

  Route::get('/', 'AdminController@index')->name('admin.dashboard');                    //ouvrir le Dashboard de l'admin

} );
