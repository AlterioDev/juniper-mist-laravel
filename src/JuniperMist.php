<?php 

namespace Basduchambre\JuniperMist;

use Illuminate\Support\Facades\Http;

class JuniperMist 
{

    // public static function resolveFacade($name)
    // {
    //     return app()[$name];
    // }

    // public static function __callStatic($method, $arguments) 
    // {
    //     return (self::resolveFacade('JuniperMist'))
    //         ->$method(...$arguments);
    // }

    public static function fetchData()
    {
        $site_id = config('junipermist.location.site_id');
        $map_id = config('junipermist.location.map_id');
        $url = config('junipermist.base_url') . '/' . $site_id . '/stats/maps/' . $map_id . '/clients';

        $response = Http::withHeaders([
            'Authorization' => config('junipermist.api_key')
        ])->get($url);
       
        return response($response);
    }

}