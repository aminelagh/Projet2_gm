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
use App\Models\Type_transaction;
use App\Models\Transaction;
use App\Models\Magasin;
use App\Models\Stock;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/t', function(){

    $id_type_transaction = Type_transaction::where('libelle','=','ajouter')->get()->first()->id_type_transaction;
    dump( $id_type_transaction );

});

Route::get('/s', function(Request $req){

    $req->session()->put('id_user',999);
    $req->session()->put('id_user',999);
    $req->session()->put('id_user',999);
    $req->session()->put('session_name',"adazdlazhdazhdizeuhfzeu fierughieugh erugh eriu gherugh ");

    echo $req->session()->get('id_user')."<br>";
    echo $req->session()->get('session_name')."<hr>";

    request()->session()->forget('session_name');

    echo request()->session()->get('id_user')."<br>";
    echo request()->session()->get('session_name')."<br>";


      //$req->session()->put('id_user',999);
      //$req->session()->put('session_name',"session de l'utilisateur numero 999 !!!");


    //$req
    //dump( request() );
    //dump( $req );
    dump( $req->session() );
    dump( $req );

    //dump( request()->session()->get('name') );

});
/*
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

/*

Route::get('/form', function () {
    return view('form')->with('articles', Article::all() );
});

Route::get('/t', function () {

  //$v = Input::get("aa");
  //$data = DB::select( DB::raw("SELECT * FROM stocks s join articles a on s.id_article=a.id_article ") );
  //$data = DB::statement('select * from users where id_role=:id', array('id' => 1) );

  return view('table')->withData( Categorie::all() );

});

*/


//Route pour generer des PDF
//Route::get('print/{param}','PDFController@imprimer')->name('print');


/***************************************
Routes Excel:
****************************************/
Route::get('/export/{p_table}','ExcelController@export')->name('export');
Route::get('/export/{p_table}','ExcelController@export')->name('export');


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

/*****************************************
Routes Lister et infos
*****************************************/
Route::get('/direct/info/{p_table}/{p_id}','ShowController@info')->name('direct.info');
Route::get('/admin/info/{p_table}/{p_id}','ShowController@info')->name('admin.info');

Route::get('/admin/lister/{p_table}','ShowController@lister')->name('admin.lister');
Route::get('/direct/lister/{p_table}','ShowController@lister')->name('direct.lister');
/*******************************************************************************/

/****************************************
Routes gestion des Stocks
*****************************************/
Route::get('/direct/addStock/{p_id_magasin}','StockController@addStock')->name('direct.addStock');
Route::post('/direct/submitAddStock','StockController@submitAddStock')->name('direct.submitAddStock');

Route::get('/direct/supply/{p_id_magasin}','StockController@supplyStock')->name('direct.supplyStock');
Route::post('/direct/submitSupply','StockController@submitSupplyStock')->name('direct.submitSupplyStock');
/*******************************************************************************/



Route::prefix('/admin')->group( function()
{
  //home --> Dashboard
  Route::get('','AdminController@home')->name('admin.home');
});



Route::prefix('/direct')->group( function()
{
  //home --> Dashboard
  Route::get('/','DirectController@home')->name('direct.home');



  //lister stocks
  Route::get('/stocks/{p_id_magasin}','StockController@listerStocks')->name('direct.stocks');

  Route::get('/update/{value}/{aa}','DirectController@routeError');
  Route::get('/update','DirectController@routeError');
});


//Route::get('/{param}',function(){  return view('welcome'); });
