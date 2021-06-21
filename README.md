# Juniper Mist API wrapper for Laravel

This is a wrapper to easily make API calls to Juniper Mist. Very basic and only one metric for now, but big plans to expand this package in the future.

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

The Mist data tables will be created upon running the migration command

```
php artisan migrate"
```

This will create the mist_fetch_data table and the mist_data table. 

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

### Filter by SSID

You can filter by SSID if you know the name. E.g.

`return JuniperMist::ssid('my_wifi_network')->get();`

### Chaining methods

It is possible to chain different methods to alter the output like below;

```
return JuniperMist::metric('unconnected_clients')
    ->ssid('my_wifi_network')
    ->setSiteId('my_site_id')
    ->setMapId('my_map_id')
    ->get()
```

## Roadmap

