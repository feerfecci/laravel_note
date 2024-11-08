<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    echo "hello word";
});

Route::get('/about', function(){
    echo "about us";
});
