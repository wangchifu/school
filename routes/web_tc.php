<?php
//教學組長
Route::group(['middleware' => 'teach_section'],function(){
    Route::get('teach_section' , 'TeachSectionController@index')->name('teach_section.index');
});