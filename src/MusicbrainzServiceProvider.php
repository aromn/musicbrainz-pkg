<?php

namespace Aromn\Musicbrainz;

use Illuminate\Support\ServiceProvider;

class MusicbrainzServiceProvider extends ServiceProvider
{
	public function boot()
	{
		$this->loadRoutesFrom(__DIR__.'/routes/web.php');
		$this->loadViewsFrom(__DIR__.'/views', 'muzicbrains');
	}

	public function register()
	{
		$this->app->singleton(Musicbrainz::class, function() {
			return new Musicbrainz();
		});
	}
} 