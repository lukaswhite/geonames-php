# Examples

### Searching for France

Let's try searching for France:

```php
$search
    ->name( 'France' )
    ->limit( 5 );
```

This returns quite a few results; the regions of Île-de-France and Hauts-de-France, the commune of Tremblay-en-France, and more.

We can narrow this down by filtering by feature code; `PCLI` represents a country.

```php
$search
    ->name( 'France' )
    ->filterByFeatureCode( 'PCLI' )
    ->limit( 5 );
```
    
Perhaps unexpectedly, this actually returns two results; France, and Mauritius.
    
The French name for Mauritius is Île de France, so the name search is picking up Mauritius.
     
There are two things we can do to narrow the search down. The first is to use `nameEquals()` instead of name:     

```php
$search
    ->nameEquals( 'France' )
    ->filterByFeatureCode( 'PCLI' )
    ->limit( 5 );
```

The second is to limit the results to Europe:

```php
$search
    ->name( 'France' )
    ->filterByFeatureCode( 'PCLI' )
    ->inContinent( \Lukaswhite\Geonames\Models\Continent::EUROPE )
    ->limit( 5 );
```


### Getting the Most Populated UK Cities

```php
$query
    ->inCountry( 'GB' )
    ->filterByFeatureCode( 'PPLC', 'PPLA', 'PPLA2' )
    ->orderByPopulation( )
    ->full( )
    ->limit( 25 );
```

### Listing the World's Tallest Mountains

```php
$query
    ->filterByFeatureCode( 'MT' )
    ->orderByElevation( )
    ->full( )
    ->limit( 10 );
```    