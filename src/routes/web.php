<?php

Route::group(['namespace' => 'Aromn\Musicbrainz\Http\Controllers'], function(){
	Route::get('artist/{artist}/{type?}/{country?}', 'MusicbrainzController@searchArtist');	
	Route::get('event/{query}', 'MusicbrainzController@searchEvent');
	Route::get('label/{query}', 'MusicbrainzController@searchLabel');
	Route::get('testing', 'MusicbrainzController@test');		
});
