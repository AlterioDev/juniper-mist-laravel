<?php 

namespace Basduchambre\JuniperMist;

use Illuminate\Support\Facades\Http;

class JuniperMist
{

    private $url;
    private $api_key;
    private $site_id;
    private $map_id;
    private $metric;
    private $ssid;

    public function __construct()
    {
        $this->url = config('junipermist.base_url');
        $this->api_key = config('junipermist.api_key');
        $this->site_id = config('junipermist.location.site_id');
        $this->map_id = config('junipermist.location.map_id');
        $this->metric = 'clients'; // Default value
        $this->ssid = '';
    }

    public function setSiteId(string $site_id)
    {
        $this->site_id = $site_id;

        return $this;
    }

    public function setMapId(string $map_id)
    {
        $this->map_id = $map_id;

        return $this;
    }

    public function metric(string $metric) 
    {
        $this->metric = $metric;

        return $this;
    }

    public function ssid(string $ssid)
    {
        $this->ssid = $ssid;

        return $this;
    }

    public function get()
    {
        $url = $this->url . '/' . $this->site_id . '/stats/maps/' . $this->map_id . '/' . $this->metric;

        $response = Http::withHeaders([
            'Authorization' => $this->api_key
        ])->get($url);
       
        return response($response);
    }

}