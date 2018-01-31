# Find Nearby

This service allows you to search for features near the specified location.

## Basic Usage

First, add the following:

```php
use Lukaswhite\Geonames\Query\ReverseGeocoding\FindNearby;
use Lukaswhite\Geonames\Models\Coordinate;
```

Create an instance of the `Coordinate`:

```php
$ccordinates = new Coordinate( [ 53.41667, -2.25 ] );
```

Run the search:

```php
$results = $service->run( new FindNearby( $coordinates ) );
```

If you want to restrict the radius:

```php
$results = $service->run( 
    ( new FindNearby( $coordinates ) )->withinRadius( 50 ) 
);
```

> The radius should be in kilometres (km)

### Filtering by Feature Class

You can restrict the results to one or more feature classes with the `filterByFeatureClass( )` method.

You can provide one feature class:

```php
// just administrative areas, for example countries
$query->filterByFeatureClass( 'A' )
```

Or multiple:

```php
// administrative areas, plus cities, towns, etc
$query->filterByFeatureClass( 'A', 'P' )
```

### Filtering by Feature Code

You can restrict the results to one or more feature codes with the `filterByFeatureCode( )` method.

You can provide one feature class:

```php
// Populated places
$query->filterByFeatureCode( 'PPL' )
```

Or multiple:

```php
// Capital cities, cities, towns
$query->filterByFeatureCode( 'PPLC', 'PPLA', 'PPLA2' )
```

## Advanced Usage

### Setting the Style (Verbosity)

```php
$query = new FindNearby( $coordinates );

$query->style( 'FULL' ) // or 'LONG', 'MEDIUM', 'SHORT'
```

Alternatively:

```php
$query = new FindNearby( $coordinates );

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
$query = new FindNearby( $coordinates );
$query->limit( 25 );
```

### Restricting the Results to the Local Country

If you want to restrict the results to the local (i.e. same) country, use the following:

```php
$query = new FindNearby( $coordinates );
$query->justLocalCountry( )
```

In other words, suppose the point is on the French side of the border between France and Spain; this would exclude towns and cities in Spain.