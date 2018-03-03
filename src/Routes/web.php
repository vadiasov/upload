<?php

// src/Routes/web.php
Route::group(['middleware' => ['web']], function () {
    Route::get('/tracks-upload/{config}/{id}', 'Vadiasov\Upload\Controllers\UploadController@upload');
    Route::post('/tracks-store', 'Vadiasov\Upload\Controllers\UploadController@store');
});
