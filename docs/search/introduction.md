# Searching

You'll probably want to add the following `use` statements:

```php
use Lukaswhite\Geonames\Geonames;
use Lukaswhite\Geonames\Query\Search;
```

You then need to set up the service: 

```php
$service = new Geonames( getenv( 'GEONAMES_USERNAME' ) );
```

Now to build the search; first, create an instance:

```php
$query = new Search( );
```

Build your search query programatically:


```php
// Search for France
$query
    ->name( 'France' )
    ->filterByFeatureCode( 'PCLI' )
    ->limit( 5 );
```
    
To run the search call the `run( )` method:
    
```php    
$results = $service->run( $query );    
print $results->count( );
    
foreach( $results as $feature ) {
    print $feature->getName( );
}
```
