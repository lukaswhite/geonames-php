# Contains

?> You'll find the web services documentation [here](http://www.geonames.org/export/place-hierarchy.html).

The `contains` query allows you to find features in another feature; for example cities in a county.

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
