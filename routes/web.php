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

// Route::get('/',function(){
// 	return view('welcome',['name'=>'英雄来自行凶']);
// });

//首页
Route::get('/',function(){
	session(['uid'=>88]);
	// request()->session()->forget('uid');
	return view('welcome',['name'=>'英雄来自行凶']);
});


// Route::get('/user','UserController@index');
Route::prefix('/user')->group(function(){
	Route::get('add','UserController@create');
	Route::post('add_do','UserController@store');
	Route::get('list','UserController@index');
	Route::get('edit/{id}','UserController@edit');
	Route::post('update','UserController@update');
	Route::get('del/{id}','UserController@destroy');
	Route::post('getArea','UserController@getArea');
});

//1周考
Route::prefix('/brand')->middleware('checklogin')->group(function(){
	Route::get('add','BrandController@create');
	Route::post('add_do','BrandController@store');
	Route::get('list','BrandController@index');
	Route::get('edit/{id}','BrandController@edit');
	Route::post('update','BrandController@update');
	Route::get('del/{id}','BrandController@destroy');
});


//2周考
Route::prefix('/stu')->group(function(){
	Route::get('add','StuController@create');
	Route::post('add_do','StuController@store');
	Route::get('list','StuController@index');
	Route::get('edit/{id}','StuController@edit');
	Route::post('update','StuController@update');
	Route::get('del/{id}','StuController@destroy');
});

//车票
Route::prefix('/che')->group(function(){
	Route::get('add','CheController@create');
	Route::post('add_do','CheController@store');
	Route::get('list','CheController@index');
	Route::get('edit/{id}','CheController@edit');
	// Route::post('update','CheController@update');
	Route::get('del/{id}','CheController@destroy');
});


//周考2
Route::prefix('/huo')->middleware('checklogin')->group(function(){
	Route::get('add','HuoController@create');
	Route::post('add_do','HuoController@store');
	Route::get('list','HuoController@index');
	Route::get('edit/{id}','HuoController@edit');
	Route::post('update','HuoController@update');
	Route::get('del/{id}','HuoController@destroy');
});

//考试1
Route::prefix('/diao')->group(function(){
	Route::get('add','DiaoController@add');
	Route::post('add_do','DiaoController@add_do');
	Route::get('list','DiaoController@list');
	Route::post('list_do','DiaoController@list_do');
	Route::get('list1','DiaoController@list1');
	Route::post('list1_do','DiaoController@list1_do');
	Route::get('list2','DiaoController@list2');
	Route::post('list2_do','DiaoController@list2_do');
	Route::get('index','DiaoController@index');
	Route::get('del/{id}','DiaoController@del');
});

 //考试2
 Route::get('aaaindex','jingcaicontroller@index');
 Route::post('addqiudui','jingcaicontroller@addqiudui');
 Route::get('jingcailist','jingcaicontroller@jingcailist');
 Route::get('canyu','jingcaicontroller@canyu');
 Route::post('jingcaidd','jingcaicontroller@jingcaidd');
 Route::get('chengj','jingcaicontroller@chengj');
 Route::get('kongzhi','jingcaicontroller@kongzhi');
 Route::post('kongzhido','jingcaicontroller@kongzhido');

// //考试3
// Route::get('ku/login','KuController@login');
// Route::post('ku/login_do','KuController@login_do');
// //车库
// Route::group(['middleware' => ['login'],'prefix'=>'/ku/'], function () {
// 	Route::get('index','KuController@index');
// 	Route::get('menadd','KuController@menadd');
// 	Route::get('menlist1','KuController@menlist1');
// 	Route::post('menlist1_do','KuController@menlist1_do');
// 	Route::get('menlist2','KuController@menlist2');
// 	Route::post('menlist2_do','KuController@menlist2_do');
// 	Route::get('cheadd','KuController@cheadd');
// 	Route::post('cheadd_do','KuController@cheadd_do');
// });

Route::get('yan/login','YanController@login');
Route::post('yan/login_do','YanController@login_do');
Route::group(['middleware' => ['login'],'prefix'=>'/yan/'], function () {
	Route::get('index','YanController@index');
	Route::post('add_do','YanController@add_do');
	Route::get('del/{id}','YanController@del');
});



	// Route::post('indexs','KouController@indexs');


Route::prefix('/kou')->group(function(){
	Route::get('add','KouController@add');
	Route::get('index','KouController@index');
	Route::get('info','KouController@info');
	Route::get('list','KouController@list');
	Route::get('del/{id}','KouController@del');
	Route::get('edit/{id}','KouController@edit');
	Route::post('update','KouController@update');
	Route::get('login','KouController@login');
	Route::get('code','KouController@code');

	Route::get('template_list','KouController@template_list'); //模板列表
	Route::get('del_template','KouController@del_template'); //模板删除
	Route::get('push_template','KouController@push_template'); //推送模板消息

	Route::get('upload_source','KouController@upload_source'); //上传素材
	Route::post('do_upload','KouController@do_upload'); 
	Route::any('matterList','KouController@matterList'); //素材展示

	Route::get('labeladd','KouController@labeladd'); //创建标签
	Route::any('labeladd_do','KouController@labeladd_do'); //标签添加执行
	Route::any('labellist','KouController@labellist'); //标签展示
	Route::get('labelfans/{id}','KouController@labelfans'); //标签粉丝展示
	Route::any('labelfansadd','KouController@labelfansadd'); //给粉丝打标签
	Route::any('labeldel','KouController@labeldel'); //标签粉丝删除
	Route::any('newsadd','KouController@newsadd');
	Route::any('newsdoadd','KouController@newsdoadd');
});
	Route::get('wechat/event','Wechat\WechatController@event');//微信推送消息

// //登入注册
// Route::get('/','IndexController@index');
// Route::get('login','LoginController@login');//登入
// Route::get('do_login','LoginController@do_login'); //登入表单提交验证
// Route::get('register'); //注册
// Route::get('do_register'); //表单验证
// Route::get('logout'); //退出


Route::prefix('/name')->group(function(){
	Route::get('login','NameController@login');
	Route::post('login_do','NameController@login_do');
	Route::get('add','NameController@create');
	Route::post('add_do','NameController@store');
	Route::get('list','NameController@index');
	Route::get('edit/{id}','NameController@edit');
	Route::post('update','NameController@update');
	Route::get('del/{id}','NameController@destroy');
	Route::get('signin','NameController@signin');
});





//接口开发文件文件上传
Route::prefix('/sang')->group(function(){
	Route::any('add','SangController@add');
	Route::any('list','SangController@list');
	Route::any('del','SangController@del');
});

Route::get('/sang/sangadd',function(){
	return view('sang.sangadd');
});
Route::get('/sang/sanglist',function(){
	return view('sang.sanglist');
});