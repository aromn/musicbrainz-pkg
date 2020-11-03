<?php

Route::group(['namespace' => 'Aromn\Musicbrainz\Http\Controllers'], function(){
	Route::get('artist/{artist}/{type?}/{country?}', 'MusicbrainzController@searchArtist');	
	Route::get('event/{query}', 'MusicbrainzController@searchEvent');
	Route::get('label/{query}', 'MusicbrainzController@searchLabel');
	Route::get('lookup/{entity}/{mbdi}/{inc?}', 'MusicbrainzController@lookup');		
	Route::get('ddown', 'MusicbrainzController@ddown');
});
