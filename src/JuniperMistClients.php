<?php

namespace Basduchambre\JuniperMist;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Basduchambre\JuniperMist\Exceptions\FailedRequest;
use Basduchambre\JuniperMist\Exceptions\InvalidApiToken;
use Basduchambre\JuniperMist\Exceptions\MissingSiteOrMapId;


class JuniperMistClients
{

    private $url;
    private $api_key;
    private $site_id;
    private $map_id;
    private $type;
    private $ssid;

    public function __construct()
    {
        $this->url = config('junipermist.base_url');
        $this->api_key = config('junipermist.api_key');
        $this->site_id = config('junipermist.location.site_id');
        $this->map_id = config('junipermist.location.map_id');
        $this->type = 'clients'; // Default value
    }

    public function siteId(string $site_id)
    {
        $this->site_id = $site_id;

        return $this;
    }

    public function mapId(string $map_id)
    {
        $this->map_id = $map_id;

        return $this;
    }

    public function type(string $type)
    {
        $this->type = $type;

        return $this;
    }

    public function ssid(string $ssid)
    {
        $this->ssid = $ssid;

        return $this;
    }

    public function get()
    {

        if ($this->api_key == null || !Str::contains($this->api_key, 'Token ')) {
            throw new InvalidApiToken('Mist API token is missing or invalid. Check if the token is set and starts with "Token ".');
        }

        if ($this->site_id == null || $this->map_id == null) {
            throw new MissingSiteOrMapId('Mist location ID\'s are missing. Check if site ID and map ID are set.');
        }

        $url = $this->url . '/' . $this->site_id . '/stats/maps/' . $this->map_id . '/' . $this->type;


        $request = Http::withHeaders([
            'Authorization' => $this->api_key
        ])->get($url);

        if ($request->getStatusCode() != 200) {
            throw new FailedRequest('API request failed with status code: ' . $request->getStatusCode() . '. Please check if your keys and metrics are correct');
        }

        $request = json_decode($request, true);

        if ($this->type == 'clients') {

            if ($this->ssid) {

                $filtered_output = [];
                foreach ($request as $connection) {
                    if (Str::slug($connection['ssid']) === Str::slug($this->ssid)) {
                        $filtered_output[] = $connection;
                    }
                }
                return response($filtered_output);
            } else {
                return response($request);
            }
        } else if ($this->type == 'unconnected_clients') {

            return response($request);
        }
    }
}
