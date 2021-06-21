<?php

namespace Basduchambre\JuniperMist;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Basduchambre\JuniperMist\Exceptions\FailedRequest;
use Basduchambre\JuniperMist\Exceptions\InvalidApiToken;
use Basduchambre\JuniperMist\Exceptions\MissingSiteOrMapId;

class JuniperMistMetrics
{

    private $url;
    private $api_key;
    private $site_id;
    private $metric;
    private $start;
    private $end;
    private $interval;

    public function __construct()
    {
        $this->url = config('junipermist.base_url');
        $this->api_key = config('junipermist.api_key');
        $this->site_id = config('junipermist.location.site_id');
        $this->metric = 'loyalty'; // Default value
        $this->interval = 86400; // Default value
    }

    public function siteId(string $site_id)
    {
        $this->site_id = $site_id;

        return $this;
    }

    public function metric(string $metric)
    {
        $this->metric = $metric;

        return $this;
    }

    public function start(int $start)
    {
        $this->start = $start;

        return $this;
    }

    public function end(int $end)
    {
        $this->end = $end;

        return $this;
    }

    public function interval(int $interval)
    {
        $this->interval = $interval;

        return $this;
    }

    public function get()
    {
        if ($this->api_key == null || !Str::contains($this->api_key, 'Token ')) {
            throw new InvalidApiToken('Mist API token is missing or invalid. Check if the token is set and starts with "Token ".');
        }

        if ($this->site_id == null) {
            throw new MissingSiteOrMapId('Mist site ID is missing. Check if it is set.');
        }

        $url = $this->url . '/' . $this->site_id . '/insights/client-' . $this->metric . '?start=' . $this->start . '&end=' . $this->end . '&interval=' . $this->interval;


        $request = Http::withHeaders([
            'Authorization' => $this->api_key
        ])->get($url);

        if ($request->getStatusCode() != 200) {
            throw new FailedRequest('API request failed with status code ' . $request->getStatusCode() . '. Please check if your keys and metrics are correct');
        }

        $request = json_decode($request, true);

        return response($request);
    }
}
