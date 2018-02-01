# Children

?> You'll find the web services documentation [here](http://www.geonames.org/export/place-hierarchy.html).

This is probably best illustrated with an example; let's take the United Kingdom.
 
![The United Kingdom](/_media/united-kingdom.png)
 
The United Kingdom is comprised of England, Wales, Scotland and Northern Ireland; i.e. they are the **children** of the United Kingdom.

```php
use Lukaswhite\Geonames\Query\Hierarchy\Children;

$results = $service->run( new Children( 2635167 ) );
```

This returns a `Resultset` with three instances of the `Feature` class.

```php
$names = $results->map( function( $item ) {
    return $item->getName( );
} )->toArray( );
 
printf( 
    'The United Kingdom is comprised of: %s',
     implode( ', ', $names )
); // prints "The United Kingdom is comprised of: England, Northern Ireland, Scotland, Wales"
```