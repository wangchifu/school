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
    Route::post('month_setup' , 'TeachSectionController@month_setup_store')->name('month_setup.store');
    Route::post('month_setup2' , 'TeachSectionController@month_setup_store2')->name('month_setup.store2');
    Route::get('month_setup_delete/{month_setup}' , 'TeachSectionController@month_setup_destroy')->name('month_setup.destroy');

    Route::get('c_group' , 'TeachSectionController@c_group')->name('c_group.index');

    Route::get('support' , 'TeachSectionController@support')->name('support.index');

    Route::get('taxation' , 'TeachSectionController@taxation')->name('taxation.index');

    Route::get('over' , 'TeachSectionController@over')->name('over.index');

});