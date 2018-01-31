# Get the Country

This service allows you to identify the country that a point is in.

!> This service only returns the country code; read on for information about how to get additional information

## Basic Usage

First, add the following:

```php
use Lukaswhite\Geonames\Query\ReverseGeocoding\CountryCode;
use Lukaswhite\Geonames\Models\Coordinate;
```

Create an instance of the `Coordinate`:

```php
$ccordinates = new Coordinate( [ 53.41667, -2.25 ] );
```

Run the search:

```php
$countryCode = $service->run( new CountryCode( $coordinates ) ); // returns GB
```

As mentioned above, this will only return a country code. You can of course use the Country Info query to get more information: 

```php
use Lukaswhite\Geonames\Query\CountryInfo;

$country = $service->run( 
    ( new CountryInfo( ) )
        ->inCountry( $countryCode ) 
    )->first( );
```

> Since most country information rarely changes, you might want to use something like [this](https://github.com/rinvex/country) instead.