# Nearest Populated Place

The nearest populated place service helps you find the city, town or village nearest to a given point; that said, "place" is slightly mis-leading in that it returns multiple places. The results are always in ascending order of distance &mdash; i.e., closest first.

## Basic Usage

First, add the following:

```php
use Lukaswhite\Geonames\Query\ReverseGeocoding\NearestPopulatedPlace;
use Lukaswhite\Geonames\Models\Coordinate;
```

Create an instance of the `Coordinate`:

```php
$ccordinates = new Coordinate( [ 53.41667, -2.25 ] );
```

Run the search:

```php
$results = $service->run( new NearestPopulatedSearch( $coordinates ) );
```

If you want to restrict the radius:

```php
$results = $service->run( 
    ( new NearestPopulatedSearch( $coordinates ) )->withinRadius( 50 ) 
);
```

> The radius should be in kilometres (km)

## Advanced Usage

### Setting the Style (Verbosity)

```php
$query = new NearestPopulatedSearch( $coordinates );

$query->style( 'FULL' ) // or 'LONG', 'MEDIUM', 'SHORT'
```

Alternatively:

```php
$query = new NearestPopulatedSearch( $coordinates );

$query->full( )
// or
$query->long( )
// or
$query->medium( )
// or
$query->short( )
```

### Limiting the Number of Results

To limit the number of results:

```php
$query = new NearestPopulatedSearch( $coordinates );
$query->limit( 25 );
```

### Filtering by Population

You can restrict the results to cities with a population of over 1,000, 5,000 or 15,000 as follows: 

```php
$query = new NearestPopulatedSearch( $coordinates );

$query->populationOver1000( )
// or
$query->populationOver5000( )
// or
$query->populationOver15000( )
```

### Restricting the Results to the Local Country

If you want to restrict the results to the local (i.e. same) country, use the following:

```php
$query = new NearestPopulatedSearch( $coordinates );
$query->justLocalCountry( )
```

In other words, suppose the point is on the French side of the border between France and Spain; this would exclude towns and cities in Spain.