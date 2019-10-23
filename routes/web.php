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

//DB::listen(function($query) {
//    var_dump($query->sql, '<br>');
//});


Auth::routes();

Route::group(['prefix' => 'backend', 'middleware' => 'auth'], function () {
    
    Route::get('/', 'AdminIndexController@index')->name('admin.index');

    Route::resource('offers', 'Admin\OffersController' , ['except' => 'show']);
    Route::resource('cats', 'Admin\CatsController' , ['except' => 'show']);
    Route::resource('roles','Admin\RolesController', ['except' => 'show']);
    Route::resource('users','Admin\UsersController', ['except' => 'show']);
    Route::resource('subways','Admin\SubwaysController', ['except' => 'show, create, store, destroy']);
    Route::resource('posts','Admin\PostsController', ['except' => 'show']);
    Route::resource('banners','Admin\BannersController', ['except' => 'show']);
    Route::resource('emails','Admin\EmailsController');
	Route::get('xml_offers',['uses'=>'Admin\XmlOffersController@index', 'as'=>'xml_offers.index']);
	Route::match(['put', 'patch'], 'xml_offers', ['uses'=>'Admin\XmlOffersController@update', 'as'=>'xml_offers.update']);
    
    Route::get('maskAsRead', function () {
        
        auth()->user()->unreadNotifications->markAsRead();
        
        return redirect()->back();
        
    })->name('markRead');
    
    Route::post('destroy_emails', 'Admin\EmailsController@destroy')->name('emails.destroy');
    
    Route::get('export_offers', 'Admin\ImportExportController@exportOffers')->name('export.offers');
    Route::get('export_cats', 'Admin\ImportExportController@exportCats')->name('export.cats');
    Route::get('importExportView', 'Admin\ImportExportController@importExportView')->name('importExportView');
    Route::post('import_offers', 'Admin\ImportExportController@importOffers')->name('import.offers');
    Route::post('import_cats', 'Admin\ImportExportController@importCats')->name('import.cats');
    
});

// Home Page
Route::get('/',['uses'=>'IndexController@index', 'as'=>'frontend.index']);
Route::post('/',['uses'=>'IndexController@filter', 'as'=>'frontend.index.filter']);

// Offers Pages
Route::group(['prefix'=>'city'], function() {
	Route::get('/',['uses'=>'OffersController@index', 'as'=>'frontend.offers.index']);
	Route::get('{slug}',['uses'=>'OffersController@show', 'as'=>'frontend.offers.show'])->where(['slug' => '(.*)(-lot-)([0-9]+)']);
	Route::get('count',['uses'=>'OffersController@count', 'as'=>'frontend.offers.count']);
	Route::get('{val1?}/{val2?}/{val3?}/',['uses'=>'OffersController@index', 'as'=>'frontend.offers.slugFilter']);
    Route::post('/',['uses'=>'OffersController@filter', 'as'=>'frontend.offers.filter']);
    Route::post('ajax',['uses'=>'OffersController@ajax', 'as'=>'frontend.offers.ajax']);

});

// Map Pages
Route::group(['prefix'=>'map'], function() {
        
    Route::get('/',['uses'=>'MapController@index', 'as'=>'frontend.map.index']);
	Route::post('ajax',['uses'=>'MapController@ajax', 'as'=>'frontend.map.ajax']);
    Route::get('point',['uses'=>'MapController@point', 'as'=>'frontend.map.point']);
    Route::post('content',['uses'=>'MapController@content', 'as'=>'frontend.map.content']);

});

//Route::get('landing/{lot}',['uses'=>'Admin\LandingController@index', 'as'=>'landing']);

// Cats Pages
Route::group(['prefix'=>'zhilye-kompleksy'], function() {
        
    Route::get('/',['uses'=>'CatsController@index', 'as'=>'frontend.cats.index']);
    Route::post('/',['uses'=>'CatsController@filter', 'as'=>'frontend.cats.filter']);
	Route::get('{slug}',['uses'=>'CatsController@show', 'as'=>'frontend.cats.show']);

});

// Forms
Route::group(['prefix'=>'form'], function() {
        
    Route::post('callme',['uses'=>'FormController@callme', 'as'=>'form.callme']);
	Route::post('plan',['uses'=>'FormController@plan', 'as'=>'form.plan']);
	Route::post('subscribe',['uses'=>'FormController@subscribe', 'as'=>'form.subscribe']);
        
});

// News Pages
Route::group(['prefix'=>'news'], function() {
        
    Route::get('/',['uses'=>'NewsController@index', 'as'=>'frontend.news.index']);
	Route::get('{slug}',['uses'=>'NewsController@show', 'as'=>'frontend.news.show'])->where(['slug' => '(.*)(-news-)([0-9]+)']);

});


Route::group(['prefix'=>'email'], function() {
        
    Route::get('/',['email'=>'EmailController@all', 'as'=>'emailform']);
        
});

Route::get('email', function () { 
        
        return view('frontend.index');
        
    });

Route::post('email',['uses'=>'EmailController@send', 'as'=>'email.send']);

Route::group(['prefix'=>'sitemap'], function() {
        
    Route::get('/', 'Admin\SitemapController@index');
	Route::get('offers', 'Admin\SitemapController@offers');
	Route::get('cats', 'Admin\SitemapController@cats');
	Route::get('news', 'Admin\SitemapController@posts');
	Route::get('other', 'Admin\SitemapController@other');

});



Route::get('/export_xml/yandex', 'Admin\YandexController@index');
Route::get('/export_xml/cian', 'Admin\CianController@index');

