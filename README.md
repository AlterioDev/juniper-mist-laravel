# Juniper Mist API wrapper for Laravel

This is a wrapper to easily make API calls to Juniper Mist. Still basic and only some metrics for now, but big plans to expand this package in the future.

## Prerequisites

- Juniper Mist API key
- Juniper Mist Site ID
- Juniper Mist Map ID

## Installation

Install the package through composer

```
composer require basduchambre/juniper-mist-laravel
```

To publish the `junipermist.php` config file, run the following command. Publishing will also make an Alias `JuniperMist`, so you don't have to import. 

```
php artisan vendor:publish --provider="Basduchambre\JuniperMist\JuniperMistServiceProvider"
```

The Mist data tables will be created upon running the migration command:

```
php artisan migrate
```

This will create two tables: mist_data to store the general metrics and mist_fetch_data to store temporary client data.

Make sure your `.env` has the following values filled

```
JUNIPER_MIST_API_KEY=
JUNIPER_MIST_SITE_ID=
JUNIPER_MIST_MAP_ID=
```

Additionally you can set the `JUNIPER_MIST_BASE_URL`. For now it is set to the default Juniper Mist api base url. If it changes in the future, you can easily set it in your `.env`.

## Usage

To retreive data, create a custom `route` and `Controller`. An example is given below.

```
namespace App\Http\Controllers;

class ExampleController extends Controller
{
    public function mist()
    {
        return JuniperMist::get();
    }
}
```

### Chaining methods

It is possible to chain different methods to alter the output like below:

```
return JuniperMist::metric('clients')
    ->setSiteId('my_site_id')
    ->setMapId('my_map_id')
    ->get()
```

### Live clients

The JuniperMist class retrieves the live client data for connected and unconnected clients. The possible methods to alter the output for this class are the following:

- type - the type of live client you want to retrieve (clients/unconnected_clients). Default is clients.
- ssid - a specific ssid name to filter the output by
- siteId - the site ID of the location you want to retrieve data from.
- mapId - the map ID of the location you want to retrieve data from.

### Client insight metrics

The JuniperMistMetrics class retrieves the client insight metrics. The possible methods to alter the output for this class are the following:

- metric - the type of metric you want to retrieve (loyalty/dwell/visit/zones). Default is loyalty.
- start - The start time for the data you want to retrieve in a Unix timestamp.
- end - The end time for the data you want to retrieve in a Unix timestamp.
- interval - The intervals in which the data will be returned in seconds (86400/3600). Default is 86400.
- siteId - the site ID of the location you want to retrieve data from.
