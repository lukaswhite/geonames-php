# Basic Usage

## Searching by Name

To search for places with "London" in their name:

```php
$query->name( 'London' )
```

To search for places named "London":

```php
$query->nameEquals( 'London' )
```

To search for places that start with a given string:

```php
$query->nameStartswith( 'London' )
```

## Restricting by Country

To restrict the results to a single country:

```php
// Just United Kingdom
$query->inCountry( 'GB' )
```

Or multiple:

```php
// United Kingdom, France or Spain
$query->inCountries( 'GB', 'FR', 'ES' )
```

## Filtering by Feature Class

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

## Filtering by Feature Code

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

## Ordering the results

```php
$query->orderBy( 'relevance' )
// or
$query->orderBy( 'population' )
// or
$query->orderBy( 'elevation' )
```

Alternatively:

```php
$query->orderByRelevance( )
// or
$query->orderByPopulation( )
// or
$query->orderByElevation( )
```