<?php

namespace Aromn\Musicbrainz;

use Illuminate\Support\ServiceProvider;

class MusicbrainzServiceProvider extends ServiceProvider
{
	public function boot()
	{
		$this->loadRoutesFrom(__DIR__.'/routes/web.php');
	}

	public function register()
	{
		$this->app->singleton(Musicbrainz::class, function() {
			return new Musicbrainz();
		});
	}
} 
