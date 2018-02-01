# Examples

### Looking up a Place by its ID

In this example we already know that England has a Geonames ID of 6269131, and now we're going to try to obtain more information about it.  

```php
$place = $service->get( 6269131 );
print $place->getName( ); // outputs "England" 
```

For more detailed information, set the style and use a subtly different approach:

```php
use Lukaswhite\Geonames\Query\Get;

$place = $service->run( ( new Get( 6269131 ) )->full( ) );
```

### Searching for France

Let's try searching for France:

```php
$query
    ->name( 'France' )
    ->limit( 5 );
```

This returns quite a few results; the regions of Île-de-France and Hauts-de-France, the commune of Tremblay-en-France, and more.

We can narrow this down by filtering by feature code; `PCLI` represents a country.

```php
$query
    ->name( 'France' )
    ->filterByFeatureCode( 'PCLI' )
    ->limit( 5 );
```
    
Perhaps unexpectedly, this actually returns two results; France, and Mauritius.
    
The French name for Mauritius is Île de France, so the name search is picking up Mauritius.
     
There are two things we can do to narrow the search down. The first is to use `nameEquals()` instead of name:     

```php
$query
    ->nameEquals( 'France' )
    ->filterByFeatureCode( 'PCLI' )
    ->limit( 5 );
```

The second is to limit the results to Europe:

```php
$query
    ->name( 'France' )
    ->filterByFeatureCode( 'PCLI' )
    ->inContinent( \Lukaswhite\Geonames\Models\Continent::EUROPE )
    ->limit( 5 );
```


### Getting the Most Populated UK Cities

The following query searches for the 25 largest cities / towns in the United Kingdom.

```php
$query
    ->inCountry( 'GB' )
    ->filterByFeatureCode( 'PPLC', 'PPLA', 'PPLA2' )
    ->orderByPopulation( )
    ->full( )
    ->limit( 25 );
```

### Listing the World's Tallest Mountains

The following query gets the 10 tallest mountains in the World.

```php
$query
    ->filterByFeatureCode( 'MT' )
    ->orderByElevation( )
    ->full( )
    ->limit( 10 );
```    

### Get the Nearest Big City to a Given Lat/Lng

In this example, we're trying to find the nearest city to the given point, use the `populationOver15000( )` method to try and get a city of a reasonable size. 

```php
use Lukaswhite\Geonames\Query\NearestPopulatedPlace;
use Lukaswhite\Geonames\Models\Coordinate;

$query = new NearestPopulatedPlace( 
    new Coordinate( [ 53.41667, -2.25 )
);

$query->populationOver15000( )
    ->withinRadius( 50 )
    ->full( )
    ->limit( 1 );
```

### The Anatomy of the United Kingdom
 
The United Kingdom is made up of England, Wales, Scotland and Northern Ireland. Here's how you might query the Geonames service to obtain that information. 
 
```php 
use Lukaswhite\Geonames\Query\Hierarchy\Siblings;

$results = $service->run( new Children( 2635167 ) );
```