# Nearby Postal Codes

This service allows you to search for postal codes near the specified location or postal code.

!> Postal code information is not available for every country. 

## Basic Usage

First, add the following:

```php
use Lukaswhite\Geonames\Query\ReverseGeocoding\NearbyPostalCodes;
use Lukaswhite\Geonames\Models\Coordinate;
```

Now you have two options. The first is to create an instance of the `Coordinate` and then instantiate the query that way:

```php
$coordinates = new Coordinate( [ 53.41667, -2.25 ] );
$query = new NearbyPostalCodes( $coordinates );
```

Alternatively, you can pass a postal code instead:

```php
$query = new NearbyPostalCodes( 8775 ); // A Swiss postal code
// or
$query = new NearbyPostalCodes( 'SW11' ); // An English postal code
// etc
```

If you do pass a postal code instead, then it's probably a good idea to explictly specify the country instead. E.g.:

```php
$query = ( new NearbyPostalCodes( 8775 ) )->inCountry( 'CH' );
// or
$query = ( new NearbyPostalCodes( 'SW11' ) )->inCountry( 'GB' );
// etc
```

You can also specify the radius:

```php
$query->withinRadius( 50 );
```

Finally, run the search:

```php
$results = $service->run( $query );
```

## The Return Value

When you run the query you get back a resultset, which is comprised of instances of `Lukaswhite\Geonames\Models\PostalCode`.

You can get the actual postcode with `getPostalCode( )`, or alternatively it implements the magic `__toString( )` method.

Each postal code result also includes the distance from the point at which you based the query; you can get this (in kilometres) using `getDistance( )`.