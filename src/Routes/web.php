<?php

// src/Routes/web.php
Route::group(['middleware' => ['web']], function () {
    // first variant
    Route::get('/tracks-upload/{config}/{id}', 'Vadiasov\Upload\Controllers\UploadController@upload');
    Route::post('/tracks-store', 'Vadiasov\Upload\Controllers\UploadController@store');
    
    // second variant
    Route::get('/arts-upload/{config}/{id}', 'Vadiasov\Upload\Controllers\UploadController@upload3');
    Route::post('/arts-store', 'Vadiasov\Upload\Controllers\UploadController@storeArts');
    
    // third variant
    Route::get('/items-upload/{config}/{parent_id}/{sub_parent_id}', 'Vadiasov\Upload\Controllers\UploadController@upload4');
    Route::post('/items-store', 'Vadiasov\Upload\Controllers\UploadController@storeArts2');
});
