<?php

namespace Aromn\Musicbrainz;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Exception\GuzzleException;

class Musicbrainz
{

	# defining base url of the musicbrainz API.
	const BASE_URL = 'http://musicbrainz.org/ws/2/';

	# defining valid entities for the API. From area to url are the core entities. From rating to iswc are non-core entities.
	private static $valid_entities = ['artist', 'event', 'label'];

	# defining valid included entities for main entities.
	private static $valid_includes = array(
		'artist' => ['recordings', 'releases', 'release-groups', 'works'],
		'label' => 'releases'
	);

	private static $browse_entities = array(
		'artist' => ['area', 'collection', 'recording', 'release', 'release-group', 'works'],
		'label' => ['area', 'collection', 'release'],
		'event' => ['area', 'artist', 'collection', 'place'] 
	);

	public static function browse(string $entity, string $included_entity, string $query)
	{
		if (!self::_validEntity($entity)) {
			echo "Not valid entity. Please use one of the followings: artist, label or event";
			exit();
		}

		if (!self::_validEntityInclude($entity, $included_entity, true)) {
			echo "Not valid included entity inside " . $entity;
			exit();
		}

		$client = new Client();

		$uri = 'http://musicbrainz.org/ws/2/' . $entity . '?' . $included_entity . '=' . $query;
		try {

			if (!$query || $query == "") {
				return response()->json([
					'error' => 'No query parameters provided.'
				], 500);
			}
			
			$res =  $client->request('GET', $uri, [
				'headers' => [
					'x-qm-key' => 'My API key',
					'Accept'     => 'application/json',
					'User-Agent' => 'Muzicbrains App/1.0 ( aldoromnn@gmail.com )',
				]
			]);
					
			$data = $res->getBody();
			$json_array = json_decode($data, true);

			print_r($json_array);
				//print_r(json_decode($data, true));
				
		} catch (GuzzleException $e) {
			return response()->json([
				'error' => $e->getMessage(),
			], 500);
		}

	}

	public static function lookup(string $entity, string $mbid, $inc)
	{
		if (!self::_validEntity($entity)) {
			echo "Not valid entity. Please use one of the followings: artist, label or event";
			exit();
		}

		$client = new Client();

		$uri = 'http://musicbrainz.org/ws/2/' . $entity . '/';
		try {

			if (!$mbid || $mbid == "") {
				return response()->json([
					'error' => 'No artist ID provided.'
				], 500);
			}

			$uri = $uri . $mbid;
			
			$res =  $client->request('GET', $uri, [
				'headers' => [
					'x-qm-key' => 'My API key',
					'Accept'     => 'application/json',
					'User-Agent' => 'Muzicbrains App/1.0 ( aldoromnn@gmail.com )',
				]
			]);
					
			$data = $res->getBody();
			$json_array = json_decode($data, true);

			print_r($json_array);
				//print_r(json_decode($data, true));
				
		} catch (GuzzleException $e) {
			return response()->json([
				'error' => $e->getMessage(),
			], 500);
		}

	}

	public static function test()
	{
		return "TEST";
	}

	public static function searchArtist($artist, $type, $country)
    {
    	$uri = 'http://musicbrainz.org/ws/2/artist/?query=artist:';
    	$client = new Client();
    	$artist = ucfirst($artist);
		try {

			if (!$artist || $artist == "") {
				return response()->json([
					'error' => 'No artist name provided.'
				], 500);
			}
			
			if ($type == "" && $country == "") 
				$uri = $uri . $artist . '&fmt=json';

			if ($type != "" && $country == "") 
				$uri = $uri . $artist . ' AND type:' . $type . '&fmt=json';

			// If in the url, the second parameter is a country code, then type is null
			// and $type is passed as the country
			if (preg_match('/[A-Z]{2}/', $type) && $country == "") {
				$uri = $uri . $artist . ' AND country:' . $type . '&fmt=json';
			}
			
			if ($type != "" && $country != "") 
				$uri = $uri . $artist . ' AND type:' . $type . ' AND country:' . $country . '&fmt=json';

			$res =  $client->request('GET', $uri, [
				'headers' => [
					'x-qm-key' => 'My API key',
					'Accept'     => 'application/json',
					'User-Agent' => 'Muzicbrains App/1.0 ( aldoromnn@gmail.com )',
				]
			]);
				
			$data = $res->getBody();
			$json_array = json_decode($data, true);
			
			foreach ($json_array['artists'] as $art) {
				if ($art['name'] == $artist) {
				 	return $art;
				 } 
			}
			//print_r(json_decode($data, true));
			
		} catch (GuzzleException $e) {
			return response()->json([
				'error' => $e->getMessage(),

			], 500);
		}
		
    	//return view('muzicbrains::test', ['name'=> $artist]);
    }

	public static function searchEvent(string $query)
	{
		

		$client = new Client();

		$uri = 'http://musicbrainz.org/ws/2/event/?query="';

		try {

			if (!$query || $query == "") {
				return response()->json([
					'error' => 'The given parameters do not match any available query type for the event resource.'
				], 500);
			}
			$uri = $uri . $query;
			$res =  $client->request('GET', $uri, [
				'headers' => [
					'x-qm-key' => 'My API key',
					'Accept'     => 'application/json',
					'User-Agent' => 'Muzicbrains App/1.0 ( aldoromnn@gmail.com )',
				]
			]);
					
			$data = $res->getBody();
			$json_array = json_decode($data, true);
			
			foreach ($json_array['events'] as $event) {
				if ($event['name'] == $query) {
				 	return $event;
				 	//return $event['id'];
				 } 
			}
				//print_r(json_decode($data, true));
				
		} catch (GuzzleException $e) {
			return response()->json([
				'error' => $e->getMessage(),
			], 500);
		}
	}

	public static function searchLabel(string $query)
	{
		$client = new Client();

		$uri = 'http://musicbrainz.org/ws/2/label/?query="';

		try {

			if (!$query || $query == "") {
				return response()->json([
					'error' => 'The given parameters do not match any available query type for the label resource.'
				], 500);
			}
			$uri = $uri . $query;
			$res =  $client->request('GET', $uri, [
				'headers' => [
					'x-qm-key' => 'My API key',
					'Accept'     => 'application/json',
					'User-Agent' => 'Muzicbrains App/1.0 ( aldoromnn@gmail.com )',
				]
			]);
					
			$data = $res->getBody();
			$json_array = json_decode($data, true);
			
			foreach ($json_array['labels'] as $label) {
				if ($label['name'] == $query) {
				 	return $label['id'];
				 } 
			}
				//print_r(json_decode($data, true));
				
		} catch (GuzzleException $e) {
			return response()->json([
				'error' => $e->getMessage(),
			], 500);
		}
	}

	public static function _validEntity(string $entity)
	{
		return in_array($entity, self::$valid_entities);
	}

	public static function _validEntityInclude(string $entity, string $includedEntity, $browse = false)
	{
		# if the entity is not a key in $valid_includes array, then return false.
		if (!isset(self::$valid_includes[$entity])) {
			return false;
		}

		if ($browse) {
			return in_array($includedEntity, self::$browse_entities[$entity]);
		}
		return in_array($includedEntity, self::$valid_includes[$entity]);
	}

}
