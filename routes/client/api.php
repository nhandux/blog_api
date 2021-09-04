<?php

Route::get('categories', 'CategoryController@index');

Route::get('posts', 'PostController@index');

Route::get('post-right', 'PostController@postRight');

Route::get('questions', 'QuestionController@index');

Route::any('{all}', function () { abort('404'); })->where(['all' => '.*']);
