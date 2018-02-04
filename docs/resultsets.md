# Working with Result Sets

Most queries return a result set; i.e. an orderd collection of results. The results themselves can be one of a number of different classes; e.g a `Feature`, `PostalCode`, `Country` and so on.
 
## Iterating Results 
 
Result sets are iterable. So you can do this:

```php
foreach ( $results as $result ) {
    // ..do something with $result
}
```

## Accessing Results by Index
 
They also implement the `ArrayAccess` interface, so you can do this:
 
```php 
$result = $results[ 0 ];
```

## Getting the First Result

If you just want the first result, you can use `first( )`;
 
```php 
$firstResult = $results->first( );
```

## Getting the Number of Results 
 
To get the number of results:
 
```php 
$numResults = $results->count( ); 
```

It also implements the `Countable` interface, so you can also do this:

```php 
$numResults = count( $results ); 
```
  
## Getting the Total Number of Results  
  
In some cases a result set will also have a total number of results:
  
```php 
$total = $results->total( ); 
```  

## Getting Results as an Array

To get the results as a simple array, just do this:

```php
$arr = $results->toArray( );
```

## The `map( )` Method

You can run a function on each result in a result set using the `map( )` method, which will return a new result set.

For example:

```php
$names = $results->map( function( Feature $feature ) {
    return $feature->getName( );
} );
```

Depending on what you're trying to do, you may wish to extend the example above slightly:

```php
$names = $results->map( function( Feature $feature ) {
    return $feature->getName( );
} )->toArray( );
```

## Pagination

Most searches allow you to specify the number of rows to return using the `limit( )` method, and the start row using `startAtRow( )`. With those sorts of queries, the `Reultset` class includes a helper method, to use in conjunction with the query clases:

```php
if ( $results->hasMore( $query->getOffset( ) ) ) {
    // there are more results available
}
```

### An Example

```php
// Build the query; note we're setting a limit of 100 rows
$query = ( new Search( ) )
    ->populationOver5000( )
    ->inCountry( 'GB' )
    ->limit( 100 );

// Run the query for the first "page"
$results = $this->service->run( $query );

doSomethingWithResults( $results );

// Now "page" the query until we've retrieved all of the results:
do {
    $results = $this->service->run( $query->nextPage( ) );
    doSomethingWithResults( $results );
} while(
    $results->hasMore( $query->getOffset( ) )
);
````