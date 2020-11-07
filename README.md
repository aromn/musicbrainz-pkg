# Musicbrainz test package

##  Test laravel package to interact with Musicbrainz API

### instructions
1. Require package inside Laravel root instance using composer:
    ```
        $ composer require aromn/muzicbrains
    ```

2. Add the following lines to your controller ***if you are using a custom controller*** and remove the default **use Illuminate\Http\Request** since it will use Guzzle request:

    ```
        namespace App\Http\Controllers;
        
        use Aromn\Musicbrainz\Musicbrainz;
        use App\Http\Controllers\Controller;
        use GuzzleHttp\Client;
        use GuzzleHttp\Message\Request;
        use GuzzleHttp\Exception\GuzzleException;
    ```
    Create the functions and add the parameters to them, the parameters expected for the functions are:
  
    ```
    **browse(string $entity, string $included_entity, string $query)**
    **lookup(string $entity, string $mbid, $inc)**
    **searchArtist($artist, $type = "", $country = "")**
    **searchEvent(string $query)**
    **searchLabel(string $mbid)**
    ```

    For example:
    
    ```
        public function searchArtist(string $artist, string $type = "", string $country = "")
	    {
	    }
    ```
    Then add the following inside the function:
    ```
        return Musicbrainz::searchArtist($artist, $type, $country);
    ```
    Or just use: **Musicbrainz::searchArtist($artist, $type, $country);** where you need to get the data
    However if you want to use the default controller created by the package, you can use it, it is located at vendor/aromn/muzicbrains/stc/Http/Controllers.

3. Add the following route in your routes.php file:

    ```
        # Laravel 8. Since Laravel 8 removed the default route namespacing...
        Route::get('entity/{artist}/{type?}/{country?}', 'App\Http\Controllers\YourController@YourFunction');
        
        # Laravel < 8
        Route::get('entity/{artist}/{type?}/{country?}', 'YourController@YourFunction');
    ```
    
    By default the package creates its own controller and routes, both located at vendor/aromn/muzicbrains/src; the routes are defined as follows:
	
    ```
        artist/{artist}/{type?}/{country?}
        # artist/coldplay/group/GB
        
        event/{query}
        # /event/Blekk%20Metal
        
        label/{query}
        # label/88aa805c-6cbe-45d2-b43e-156e94090da9
        
        lookup/{entity}/{mbdi}/{inc?}
        # lookup/artist/8b8a38a9-a290-4560-84f6-3d4466e8d791
    ```

All the functions are defined in vendor/aromn/muzicbrains/src/Musicbrainz.php
