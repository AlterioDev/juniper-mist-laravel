<?php
namespace Basduchambre\JuniperMist;

use Basduchambre\JuniperMist\Exceptions\BadRequest;
use Basduchambre\JuniperMist\Exceptions\InvalidApiToken;
use Basduchambre\JuniperMist\Exceptions\MissingSiteOrMapId;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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
        if ($this->api_key == null || ! Str::contains($this->api_key, 'Token ')) {
            throw new InvalidApiToken('API Token missing or invalid.');
        }

        if ($this->site_id == null || $this->map_id == null) {
            throw new MissingSiteOrMapId('Mist location id\'s are missing. Check if they are set.');
        }

        $url = $this->url . '/' . $this->site_id . '/stats/maps/' . $this->map_id . '/' . $this->metric;

        try {
            $request = Http::withHeaders([
                'Authorization' => $this->api_key,
            ])->get($url);

            if ($request->getStatusCode() != 200) {
                throw new BadRequest($request);
            }

            $request = json_decode($request, true);

            if ($this->metric == 'clients') {
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
            } elseif ($this->metric == 'unconnected_clients') {
                return response($request);
            }
        } catch (Exception $exception) {
            return $exception;
        }
    }
}
