<?php

namespace Aromn\Musicbrainz\Http\Controllers;

use Aromn\Musicbrainz\Musicbrainz;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Exception\GuzzleException;

class MusicbrainzController extends Controller
{
	public function searchArtist(string $artist, string $type = "", string $country = "")
	{
		return Musicbrainz::searchArtist($artist, $type, $country);
	}
    

    public static function searchEvent(string $query)
	{
		return Musicbrainz::searchEvent($query);
	}


	public static function searchLabel(string $query)
	{
		return Musicbrainz::searchLabel($query);
	}

	public static function lookup($entity, $mbdi, $inc = "")
	{
		return Musicbrainz::lookup($entity, $mbdi, $inc);
	}
}
