# Juniper Mist API wrapper for Laravel

This is a wrapper to easily make API calls to Juniper Mist.

## Prerequisites

-   Juniper Mist API key
-   Juniper Mist Site ID
-   Juniper Mist Map ID

## Installation

Install the package through composer

```
composer require basduchambre/juniper-mist-laravel
```

To publish the `junipermist.php` config file, run the following command

```
php artisan vendor:publish --provider="Basduchambre\JuniperMist\JuniperMistServiceProvider"
```

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

use Basduchambre\JuniperMist\JuniperMist;

class ExampleController extends Controller
{
    public function mist()
    {
        return JuniperMist::fetchData();
    }
}
```

## Roadmap

-   Choose metric to fetch
    -   Dwelltime
    -   Recurring visitors
    -   Etc.
-   Filter by SSID
-   Filter by date
