# Geonames for PHP

> This is by no means finished, so I wouldn't recommend trying to use it just yet.

## A Taster

```php
$search = ( new Search( ) )
    ->inCountry( 'GB' )
    ->populationOver15000( )    
    ->orderByPopulation( )
    ->full( )
    ->limit( 25 );
    
$results = $api->run( $search );    
```