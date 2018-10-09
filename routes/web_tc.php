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
    Route::post('c_group/store' , 'TeachSectionController@c_group_store')->name('c_group.store');
    Route::get('c_group/{ori_sub}/show' , 'TeachSectionController@c_group_show')->name('c_group.show');
    Route::get('c_group/{ori_sub}/delete' , 'TeachSectionController@c_group_delete')->name('c_group.delete');
    Route::get('c_group/report' , 'TeachSectionController@c_group_report')->name('c_group.report');
    Route::post('c_group/send_report' , 'TeachSectionController@c_group_send_report')->name('c_group.send_report');
    Route::post('c_group/print' , 'TeachSectionController@c_group_print')->name('c_group.print');



    Route::get('support' , 'TeachSectionController@support')->name('support.index');

    Route::get('taxation' , 'TeachSectionController@taxation')->name('taxation.index');

    Route::get('short' , 'TeachSectionController@short')->name('short.index');

    Route::get('over' , 'TeachSectionController@over')->name('over.index');

    Route::get('teacher_abs' , 'TeachSectionController@teacher_abs')->name('teacher_abs.index');
    Route::post('teacher_abs/sore' , 'TeachSectionController@teacher_abs_store')->name('teacher_abs.store');
    Route::get('teacher_abs/{ori_sub}/show' , 'TeachSectionController@teacher_abs_show')->name('teacher_abs.show');
    Route::get('teacher_abs/{ori_sub}/delete' , 'TeachSectionController@teacher_abs_delete')->name('teacher_abs.delete');
    Route::get('teacher_abs/report' , 'TeachSectionController@teacher_abs_report')->name('teacher_abs.report');
    Route::post('teacher_abs/send_report' , 'TeachSectionController@teacher_abs_send_report')->name('teacher_abs.send_report');
    Route::post('teacher_abs/print' , 'TeachSectionController@teacher_abs_print')->name('teacher_abs.print');

    Route::get('class_teacher' , 'TeachSectionController@class_teacher')->name('class_teacher.index');

});