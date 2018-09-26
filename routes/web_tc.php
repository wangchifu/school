<?php
//教學組長
Route::group(['middleware' => 'teach_section'],function(){
    Route::get('teach_section' , 'TeachSectionController@index')->name('teach_section.index');
    Route::get('substitute_teacher' , 'TeachSectionController@substitute_teacher')->name('substitute_teacher.index');
    Route::post('substitute_teacher' , 'TeachSectionController@substitute_teacher_store')->name('substitute_teacher.store');
    Route::patch('substitute_teacher/{substitute_teacher}' , 'TeachSectionController@substitute_teacher_update')->name('substitute_teacher.update');
    Route::get('substitute_teacher_change/{substitute_teacher}' , 'TeachSectionController@substitute_teacher_change')->name('substitute_teacher.change');
    Route::get('substitute_teacher_destroy/{substitute_teacher}' , 'TeachSectionController@substitute_teacher_destroy')->name('substitute_teacher.destroy');

    Route::get('month_setup' , 'TeachSectionController@month_setup')->name('month_setup.index');

});