<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {
//
//    Route::get('/', 'Home\IndexController@index');
//    Route::get('/cate/{cate_id}', 'Home\IndexController@cate');
//    Route::get('/a/{art_id}', 'Home\IndexController@article');
//
    Route::any('admin/login', 'Admin\LoginController@login');
    Route::get('admin/code', 'Admin\LoginController@code');
});


Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::get('index', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    Route::get('quit', 'LoginController@quit');
    Route::any('pass', 'IndexController@pass');

//    Route::post('cate/changeorder', 'CategoryController@changeOrder');
//    Route::resource('category', 'CategoryController');

//    Route::resource('article', 'ArticleController');

//    Route::post('links/changeorder', 'LinksController@changeOrder');
//    Route::resource('links', 'LinksController');

//    Route::post('navs/changeorder', 'NavsController@changeOrder');
//    Route::resource('navs', 'NavsController');

//    Route::get('config/putfile', 'ConfigController@putFile');
//    Route::post('config/changecontent', 'ConfigController@changeContent');
//    Route::post('config/changeorder', 'ConfigController@changeOrder');
//    Route::resource('config', 'ConfigController');
    
//    Route::get('index', 'IndexController@info');
//    
//    Route::get('', 'IndexController@info');

    Route::any('upload', 'CommonController@upload');
    
    Route::resource('quiz', 'QuizController');
    
    Route::get('video/uploadView', 'VideoController@uploadView');
    Route::get('video', 'VideoController@index');
    Route::post('video/upload', 'VideoController@upload');
    
    Route::get('notice/{type?}', 'NoticeController@index');
    Route::get('notice/create/{id?}', 'NoticeController@create');
    Route::post('notice/save', 'NoticeController@save');

    Route::get('narcotics', 'NarcoticsController@index');
    Route::get('narcotics/create/{id?}', 'NarcoticsController@create');
    Route::post('narcotics/save', 'NarcoticsController@save');
    
});

//'prefix'=>'web',

Route::group(['middleware' => ['web'] , 'namespace'=>'Web'], function () {
    
    Route::get('/', 'IndexController@index')->name('index');
    Route::get('/dpxq', 'IndexController@dpxq')->name('dpxq');
    Route::get('/gz', 'IndexController@gz')->name('gz');
    Route::get('/jd', 'IndexController@jd')->name('jd');
    Route::get('/rs', 'IndexController@rs')->name('rs');
    Route::get('/xc', 'IndexController@xc')->name('xc');
    

    Route::get('/jddt_start', 'IndexController@jddt_start')->name('jddt_start');
    Route::any('/jd_answer', 'IndexController@jd_answer')->name('jd_answer');
    
    Route::any('/xddl', 'IndexController@xddl')->name('xddl')->middleware(['web.login']);
    Route::any('/xddl_upload', 'IndexController@xddl_upload')->name('xddl_upload')->middleware(['web.login']);
    Route::any('/xd_year', 'IndexController@xd_year')->name('xd_year')->middleware(['web.login']);;
});


Route::get('/test', 'Web\IndexController@test')->name('test');