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


Route::get('/' , 'HomeController@index')->name('index');

//Auth::routes();
//登入/登出
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
//首頁
//Route::get('/home', 'HomeController@index')->name('home');

//公告系統
Route::get('posts' , 'PostController@index')->name('posts.index');
Route::get('posts/{post}' , 'PostController@show')->where('post', '[0-9]+')->name('posts.show');
Route::post('posts/search' , 'PostController@search')->name('posts.search');
Route::get('posts/{job_title}/job_title' , 'PostController@job_title')->name('posts.job_title');


//公開文件
Route::get('open_files/{path?}' , 'OpenFileController@index')->name('open_files.index');
Route::get('open_files_download/{path}' , 'OpenFileController@download')->name('open_files.download');



//內容頁面
Route::get('contents/{content}' , 'ContentController@show')->where('content', '[0-9]+')->name('contents.show');

//顯示上傳的圖片
Route::get('img/{path}', 'HomeController@getImg');

//下載上傳的檔案
Route::get('file/{file}', 'HomeController@getFile');
//下載public的檔案
Route::get('public_file/{file}', 'HomeController@getPublicFile');


//管理員
Route::group(['middleware' => 'admin'],function(){
    Route::get('users', 'UserController@index')->name('users.index');
    Route::get('users/create', 'UserController@create')->name('users.create');
    Route::post('users', 'UserController@store')->name('users.store');
    Route::delete('users/{user}', 'UserController@destroy')->name('users.destroy');
    Route::get('users/{user}', 'UserController@edit')->name('users.edit');
    Route::patch('users/{user}', 'UserController@update')->name('users.update');
    Route::patch('users_resetPw/{user}', 'UserController@users_resetPw')->name('users.resetPw');
    Route::get('users_allEdit', 'UserController@users_allEdit')->name('users.allEdit');
    Route::patch('users_allUpdate', 'UserController@users_allUpdate')->name('users.allUpdate');

    Route::get('groups', 'GroupController@index')->name('groups.index');
    Route::get('groups/create', 'GroupController@create')->name('groups.create');
    Route::post('groups', 'GroupController@store')->name('groups.store');
    Route::delete('groups/{group}', 'GroupController@destroy')->name('groups.destroy');
    Route::get('groups/{group}', 'GroupController@edit')->name('groups.edit');
    Route::patch('groups/{group}', 'GroupController@update')->name('groups.update');
    //記錄使用者群組
    Route::get('users_groups/{group}', 'GroupController@users_groups')->name('users_groups');
    Route::post('users_groups', 'GroupController@users_groups_store')->name('users_groups.store');
    Route::delete('users_groups', 'GroupController@users_groups_destroy')->name('users_groups.destroy');


    //內容管理
    Route::get('contents', 'ContentController@index')->name('contents.index');
    Route::get('contents/create', 'ContentController@create')->name('contents.create');
    Route::post('contents', 'ContentController@store')->name('contents.store');
    Route::delete('contents/{content}', 'ContentController@destroy')->name('contents.destroy');
    Route::get('contents/{content}/edit', 'ContentController@edit')->name('contents.edit');
    Route::patch('contents/{content}', 'ContentController@update')->name('contents.update');

    //ckeditor及file manager管理員的檔案上傳
    Route::get('admin/file', '\Unisharp\Laravelfilemanager\controllers\LfmController@show');
    Route::post('admin/upload', '\Unisharp\Laravelfilemanager\controllers\UploadController@upload');

    //連結管理
    Route::get('links', 'LinkController@index')->name('links.index');
    Route::get('links/create', 'LinkController@create')->name('links.create');
    Route::post('links', 'LinkController@store')->name('links.store');
    Route::delete('links/{link}', 'LinkController@destroy')->name('links.destroy');
    Route::get('links/{link}/edit', 'LinkController@edit')->name('links.edit');
    Route::patch('links/{link}', 'LinkController@update')->name('links.update');

    //指定管理
    Route::get('funs', 'FunController@index')->name('funs.index');
    Route::get('funs/create', 'FunController@create')->name('funs.create');
    Route::post('funs', 'FunController@store')->name('funs.store');
    Route::delete('funs/{fun}', 'FunController@destroy')->name('funs.destroy');

    //會議文稿
    Route::get('meetings/{meeting}/edit' , 'MeetingController@edit')->name('meetings.edit');
    Route::patch('meetings/{meeting}' , 'MeetingController@update')->name('meetings.update');
    Route::delete('meetings/{meeting}', 'MeetingController@destroy')->name('meetings.destroy');

    //教室預約
    Route::get('classrooms','ClassroomController@index')->name('classrooms.index');
    Route::get('classrooms/create','ClassroomController@create')->name('classrooms.create');
    Route::post('classrooms', 'ClassroomController@store')->name('classrooms.store');
    Route::get('classrooms/{classroom}/edit' , 'ClassroomController@edit')->name('classrooms.edit');
    Route::patch('classrooms/{classroom}' , 'ClassroomController@update')->name('classrooms.update');
    Route::delete('classrooms/{classroom}', 'ClassroomController@destroy')->name('classrooms.destroy');


});

//行政人員
Route::group(['middleware' => 'exec'],function(){
# 公告系統
    Route::get('posts/create' , 'PostController@create')->name('posts.create');
    Route::post('posts' , 'PostController@store')->name('posts.store');
    Route::get('posts/{post}/edit' , 'PostController@edit')->name('posts.edit');
    Route::patch('posts/{post}' , 'PostController@update')->name('posts.update');
    Route::delete('posts/{post}', 'PostController@destroy')->name('posts.destroy');
    //刪檔案
    Route::get('posts/{file}/fileDel' , 'PostController@fileDel')->name('posts.fileDel');


    //會議文稿
    Route::get('meetings/create' , 'MeetingController@create')->name('meetings.create');
    Route::post('meetings' , 'MeetingController@store')->name('meetings.store');
    //報告內容
    Route::get('meetings_reports/{meeting}/create' , 'ReportController@create')->name('meetings_reports.create');
    Route::post('meetings_reports' , 'ReportController@store')->name('meetings_reports.store');
    Route::get('meetings_reports/{report}/edit' , 'ReportController@edit')->name('meetings_reports.edit');
    Route::patch('meetings_reports/{report}' , 'ReportController@update')->name('meetings_reports.update');
    Route::delete('meetings_reports/{report}', 'ReportController@destroy')->name('meetings_reports.destroy');
    //刪檔案
    Route::get('meetings_reports/{file}/fileDel' , 'ReportController@fileDel')->name('meetings_reports.fileDel');

    //公開文件
    Route::get('open_files_create' , 'OpenFileController@create')->name('open_files.create');
    Route::get('open_files_delete/{path}' , 'OpenFileController@delete')->name('open_files.delete');
    Route::post('open_files_create_folder' , 'OpenFileController@create_folder')->name('open_files.create_folder');
    Route::post('open_files_upload_file' , 'OpenFileController@upload_file')->name('open_files.upload_file');

    //校務計畫
    Route::get('school_plans_create' , 'SchoolPlanController@create')->name('school_plans.create');
    Route::get('school_plans_delete/{path}' , 'SchoolPlanController@delete')->name('school_plans.delete');
    Route::post('school_plans_create_folder' , 'SchoolPlanController@create_folder')->name('school_plans.create_folder');
    Route::post('school_plans_upload_file' , 'SchoolPlanController@upload_file')->name('school_plans.upload_file');


    //刪檔案
    Route::get('open_files/{file}/fileDel' , 'OpenFileController@fileDel')->name('open_files.fileDel');

    //問卷系統
    Route::get('tests/create', 'TestController@create')->name('tests.create');
    Route::get('tests/{test}/copy', 'TestController@copy')->where('test', '[0-9]+')->name('tests.copy');
    Route::post('tests', 'TestController@store')->name('tests.store');
    Route::delete('tests/{test}', 'TestController@destroy')->name('tests.destroy');
    Route::get('tests/{test}/edit', 'TestController@edit')->name('tests.edit');
    Route::patch('tests/{test}', 'TestController@update')->name('tests.update');
    Route::get('questions/{test}/index', 'QuestionController@index')->where('test', '[0-9]+')->name('questions.index');
    Route::get('questions/{test}/create', 'QuestionController@create')->where('test', '[0-9]+')->name('questions.create');
    Route::post('questions', 'QuestionController@store')->name('questions.store');
    Route::delete('questions/{question}', 'QuestionController@destroy')->where('question', '[0-9]+')->name('questions.destroy');
    Route::get('answers/{test}/show', 'AnswerController@show')->where('test', '[0-9]+')->name('answers.show');
    Route::get('tests/{test}/type/{type}','TestController@download')->name('tests.download');

});

//註冊會員
Route::group(['middleware' => 'auth'],function() {
    //變更個人設定
    Route::get('userData', 'HomeController@userData')->name('userData');
    Route::post('userData/update', 'HomeController@userData_update')->name('userData.update');
    Route::post('userData/resetPw', 'HomeController@userData_resetPw')->name('userData.resetPw');

    //會議文稿
    Route::get('meetings' , 'MeetingController@index')->name('meetings.index');
    Route::get('meetings/{meeting}' , 'MeetingController@show')->where('meeting', '[0-9]+')->name('meetings.show');

    //校務計畫
    Route::get('school_plans/{path?}' , 'SchoolPlanController@index')->name('school_plans.index');
    Route::get('school_plans_download/{path}' , 'SchoolPlanController@download')->name('school_plans.download');

    //報修系統
    Route::get('fixes', 'FixController@index')->name('fixes.index');
    Route::get('fixes_search/{situation}/type', 'FixController@search')->name('fixes.search');
    Route::get('fixes/{fix}' , 'FixController@show')->where('fix', '[0-9]+')->name('fixes.show');
    Route::get('fixes/create', 'FixController@create')->name('fixes.create');
    Route::post('fixes', 'FixController@store')->name('fixes.store');
    Route::delete('fixes/{fix}', 'FixController@destroy')->name('fixes.destroy');
    Route::patch('fixes/{fix}', 'FixController@update')->name('fixes.update');

    //學生管理
    Route::any('students', 'StudentController@index')->name('students.index');
    Route::post('students_import', 'StudentController@import')->name('students.import');
    Route::get('students/{semester}/clear_students', 'StudentController@clear_students')->name('students.clear_students');
    Route::get('students/{semester}/clear_all', 'StudentController@clear_all')->name('students.clear_all');
    Route::get('students/{year_class}' , 'StudentController@show')->where('year_class', '[0-9]+')->name('students.show');

    Route::patch('students/update', 'StudentController@update')->name('students.update');
    Route::get('students_out/{semester_student}' , 'StudentController@out')->name('students.out');
    Route::get('students_rein/{semester_student}' , 'StudentController@rein')->name('students.rein');
    Route::post('students/add_stud', 'StudentController@add_stud')->name('students.add_stud');


    //新增學期
    Route::get('year_class/create', 'YearClassController@create')->name('year_classes.create');
    Route::post('year_class/store', 'YearClassController@store')->name('year_classes.store');
    Route::patch('year_class/update', 'YearClassController@update')->name('year_classes.update');

    //問卷系統
    Route::get('tests', 'TestController@index')->name('tests.index');
    Route::get('tests/{test}/input', 'TestController@input')->where('test', '[0-9]+')->name('tests.input');
    Route::get('tests/{test}/re_input', 'TestController@re_input')->where('test', '[0-9]+')->name('tests.re_input');
    Route::post('answers/store', 'AnswerController@store')->name('answers.store');
    Route::patch('answers/update', 'AnswerController@update')->name('answers.update');

    //教室預約
    Route::get('classroom_order', 'ClassroomOrderController@index')->name('classroom_orders.index');

});

