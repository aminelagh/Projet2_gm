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
use App\Models\Stock;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/proc', function () {
  dump( DB::select("SELECT hello('aaaa') as rep; ") );
  echo '<hr>';
  dump( DB::select("call getArticlesForStock(1); ") );
  echo '<hr>';
    $id = 1;
    $data =  DB::select("select * from articles where id_article not in (select id_article from stocks where id_magasin=".$id.")");

    foreach( $data as $item )
    {
      echo $item->id_article." ".$item->designation_c." ".$item->couleur." ".$item->prix_achat." ".$item->prix_vente."<br>";
    }
    echo '<hr>';
    //dump( DB::select("SELECT getArticlesForStock(2) ") );
});



Route::get('/form', function () {
    return view('form')->with('articles', Article::all() );
});

Route::get('/t', function () {

  //$v = Input::get("aa");
  //$data = DB::select( DB::raw("SELECT * FROM stocks s join articles a on s.id_article=a.id_article ") );
  //$data = DB::statement('select * from users where id_role=:id', array('id' => 1) );

  return view('table')->withData( Categorie::all() );

});




//Route pour generer des PDF
Route::get('print/{param}','PDFController@imprimer')->name('print');





/**************************************
Routes AddForm et SubmitAdd
***************************************/
Route::get('/admin/add/{p_table}','AddController@addForm')->name('admin.add');
Route::post('/admin/submitAdd/{p_table}','AddController@submitAdd')->name('admin.submitAdd');

Route::get('/direct/add/{p_table}','AddController@addForm')->name('direct.add');
Route::post('/direct/submitAdd/{p_table}','AddController@submitAdd')->name('direct.submitAdd');
/******************************************************************************/

/**************************************
Routes Update
***************************************/
Route::get('/admin/update/{p_table}/{p_id}','UpdateController@updateForm')->name('admin.update');
Route::post('/admin/submitUpdate/{p_table}','UpdateController@submitUpdate')->name('admin.submitUpdate');

Route::get('/direct/update/{p_table}/{p_id}','UpdateController@updateForm')->name('direct.update');
Route::post('/direct/submitUpdate/{p_table}','UpdateController@submitUpdate')->name('direct.submitUpdate');

/******************************************************************************/

/**************************************
Routes Delete
***************************************/
Route::get('/admin/delete/{p_table}/{p_id}','DeleteController@delete')->name('admin.delete');
Route::get('/direct/delete/{p_table}/{p_id}','DeleteController@delete')->name('direct.delete');
/******************************************************************************/



/**************************
Routes pour l espace Admin
***************************/

Route::prefix('/admin')->group( function()
{
  //home --> Dashboard
  Route::get('','AdminController@home')->name('admin.home');


  //update user


  //update password


  //delete User
  Route::get('/deleteUser/{id}','AdminController@deleteUser')->name('admin.deleteUser');

  //lister les utlisateurs & trier les users
  Route::get('/lister','AdminController@listerUsers')->name('admin.lister');
  Route::get('/lister/{orderby}','AdminController@listerUsersOrder')->name('admin.listerOrder');

  //afficher le profile d un user:
  Route::get('/infoUser/{id}','AdminController@infoUser')->name('admin.infoUser');
});




/***************************
Routes pour l espace Direct
***************************/

Route::prefix('/direct')->group( function()
{
  //home --> Dashboard
  Route::get('/','DirectController@home')->name('direct.home');


  Route::get('/addStock/{p_id_magasin}','DirectController@addFormStock')->name('direct.addFormStock');  //formulaire d'ajout au stock

  //lister
  Route::get('/lister/{param}','DirectController@lister')->name('direct.lister');

  //delete data
  Route::get('/delete/{p_table}/{p_id}','DirectController@delete')->name('direct.delete');

  //afficher le profile
  Route::get('/info/{p_table}/{p_id}','DirectController@info')->name('direct.info');

  //afficher

  //lister stocks
  Route::get('/stocks/{p_id_magasin}','DirectController@listerStocks')->name('direct.stocks');

  Route::get('/update/{value}/{aa}','DirectController@routeError');
  Route::get('/update','DirectController@routeError');

});


Route::get('/{param}',function(){
  return view('welcome');
});
