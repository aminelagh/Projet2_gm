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
use App\Models\Promotion;
use App\Models\Remise;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/r', function () {
    for($i=0;$i<100;$i++)
    {
        echo Session::get('id_magasin');
        $id = $i;
        if(Promotion::hasPromotion($id,1))
            echo '<li>$i true';
        else echo '<li>$i false';
    }

});

Route::get('/a', function () {
    $x = collect(DB::select("call getPromotions;"));
    dump($x);
});


Route::get('/s', function (Request $req) {

    $req->session()->put('id_user', 999);
    $req->session()->put('id_user', 999);
    $req->session()->put('id_user', 999);
    $req->session()->put('session_name', "adazdlazhdazhdizeuhfzeu fierughieugh erugh eriu gherugh ");

    echo $req->session()->get('id_user') . "<br>";
    echo $req->session()->get('session_name') . "<hr>";

    request()->session()->forget('session_name');

    echo request()->session()->get('id_user') . "<br>";
    echo request()->session()->get('session_name') . "<br>";


    //$req->session()->put('id_user',999);
    //$req->session()->put('session_name',"session de l'utilisateur numero 999 !!!");


    //$req
    //dump( request() );
    //dump( $req );
    dump($req->session());
    dump($req);

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
 * Routes Excel:
 ****************************************/
Route::get('/export/{p_table}', 'ExcelController@export')->name('export');
/*********************************************************************************/


/**************************************
 * Routes AddForm et SubmitAdd
 ***************************************/
Route::get('/admin/add/{p_table}', 'AddController@addForm')->name('admin.add');
Route::post('/admin/submitAdd/{p_table}', 'AddController@submitAdd')->name('admin.submitAdd');

Route::get('/direct/add/{p_table}', 'AddController@addForm')->name('direct.add');
Route::post('/direct/submitAdd/{p_table}', 'AddController@submitAdd')->name('direct.submitAdd');

Route::get('/magas/add/{p_table}', 'AddController@addForm')->name('magas.add');
Route::post('/magas/submitAdd/{p_table}', 'AddController@submitAdd')->name('magas.submitAdd');
/******************************************************************************/

/**************************************
 * Routes Update
 ***************************************/
Route::get('/admin/update/{p_table}/{p_id}', 'UpdateController@updateForm')->name('admin.update');
Route::post('/admin/submitUpdate/{p_table}', 'UpdateController@submitUpdate')->name('admin.submitUpdate');

Route::get('/direct/update/{p_table}/{p_id}', 'UpdateController@updateForm')->name('direct.update');
Route::post('/direct/submitUpdate/{p_table}', 'UpdateController@submitUpdate')->name('direct.submitUpdate');

Route::get('/magas/update/{p_table}/{p_id}', 'UpdateController@updateForm')->name('magas.update');
Route::post('/magas/submitUpdate/{p_table}', 'UpdateController@submitUpdate')->name('magas.submitUpdate');
/******************************************************************************/

/**************************************
 * Routes Delete
 ***************************************/
Route::get('/admin/delete/{p_table}/{p_id}', 'DeleteController@delete')->name('admin.delete');
Route::get('/direct/delete/{p_table}/{p_id}', 'DeleteController@delete')->name('direct.delete');
Route::get('/magas/delete/{p_table}/{p_id}', 'DeleteController@delete')->name('magas.delete');
/******************************************************************************/

/*****************************************
 * Routes Lister et infos
 *****************************************/
Route::get('/direct/info/{p_table}/{p_id}', 'ShowController@info')->name('direct.info');
Route::get('/admin/info/{p_table}/{p_id}', 'ShowController@info')->name('admin.info');
Route::get('/magas/info/{p_table}/{p_id}', 'ShowController@info')->name('magas.info');

Route::get('/admin/lister/{p_table}', 'ShowController@lister')->name('admin.lister');
Route::get('/direct/lister/{p_table}', 'ShowController@lister')->name('direct.lister');
Route::get('/magas/lister/{p_table}', 'ShowController@lister')->name('magas.lister');
/*******************************************************************************/

/****************************************
 * Routes gestion des Stocks
 *****************************************/
Route::get('/direct/addStock/{p_id_magasin}', 'StockController@addStock')->name('direct.addStock');
Route::post('/direct/submitAddStock', 'StockController@submitAddStock')->name('direct.submitAddStock');

Route::get('/direct/supply/{p_id_magasin}', 'StockController@supplyStock')->name('direct.supplyStock');
Route::post('/direct/submitSupply', 'StockController@submitSupplyStock')->name('direct.submitSupplyStock');

//magasinier
Route::get('/magas/addStock/{p_id_magasin}', 'StockController@addStock')->name('magas.addStock');
Route::post('/magas/submitAddStock', 'StockController@submitAddStock')->name('magas.submitAddStock');

Route::get('/magas/supply/{p_id_magasin}', 'StockController@supplyStock')->name('magas.supplyStock');
Route::post('/magas/submitSupply', 'StockController@submitSupplyStock')->name('magas.submitSupplyStock');
/*******************************************************************************/


Route::prefix('/admin')->group(function () {
    Route::get('', 'AdminController@home')->name('admin.home');
});

Route::prefix('/magas')->group(function () {
    //home --> Dashboard
    Route::get('', 'MagasController@home')->name('magas.home');
});


Route::prefix('/direct')->group(function () {
    //home --> Dashboard
    Route::get('/', 'DirectController@home')->name('direct.home');
    //lister stocks
    Route::get('/stocks/{p_id_magasin}', 'StockController@listerStocks')->name('direct.stocks');
    Route::get('/update/{value}/{aa}', 'DirectController@routeError');
    Route::get('/update', 'DirectController@routeError');
});


/*********************************************************************************************
 * Routes de l'espace Vendeur
 **********************************************************************************************/

Route::prefix('/vend')->group(function () {

    //home --> Dashboard
    Route::get('/', 'VendeurController@home')->name('vend.home');

    //Lister les ventes,les promotions et le stock d'un magasin
    Route::get('/lister/{p_table}/{p_id}', 'VendeurController@lister')->name('vend.lister');


    //Visualiser les details de la transaction
    //Route::get('/details/{p_id}', 'VendeurController@detailTrans')->name('vend.details');
    //Route::get('/lister/{p_table}','VendeurController@lister')->name('vendeur.lister');

    //Ajouter une vente
    Route::get('/addVente', 'VendeurController@addFormVente')->name('vend.addVente');
    Route::post('/submitAddVente', 'VendeurController@submitAddVente')->name('vend.submitAddVente');

    //Valider l'ajout de la vente
    Route::get('/menu/{p_id_mag}', 'VendeurController@getMagasin')->name('vend.menu');

});

