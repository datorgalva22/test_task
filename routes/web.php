<?php

Route::get('/', 'GuideController@showGuide');

Route::get('/getguide/{id}', 'GuideController@getGuide');

Route::get('/getinfo/{id}', 'GuideController@getInfo');

Route::get('/renewGuide', 'GuideController@renewGuide');

Route::get('/getchannels', 'ChannelController@getChannels');

 