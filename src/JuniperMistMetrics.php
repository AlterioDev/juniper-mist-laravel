<?php

namespace Basduchambre\JuniperMist;

use Exception;
use Illuminate\Support\Facades\Http;


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
        $this->metric = 'clients'; // Default value
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
            return response()->json([
                'message' => "Mist API key missing or invalid token. Check if the token is set and starts with 'Token '."
            ], 500);
        }

        if ($this->site_id == null || $this->map_id == null) {
            //return response("Mist location id's are missing. Check if they are set.");
            return response()->json([
                'message' => "Mist location id's are missing. Check if they are set"
            ], 500);
        }

        $url = $this->url . '/' . $this->site_id . '/insights/client-' . $this->metric . '?start=' . $this->start . '&end=' . $this->end . '&interval=' . $this->interval;

        try {
            $request = Http::withHeaders([
                'Authorization' => $this->api_key
            ])->get($url);

            if ($request->getStatusCode() != 200) {
                return response()->json([
                    'message' => "Mist API request failed. Check if your location ID's are correct"
                ], $request->getStatusCode());
            }

            $request = json_decode($request, true);

            return response($request);
        } catch (Exception $exception) {

            return $exception;
        }
    }
}
