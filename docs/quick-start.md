# Quick Start

## Installation

> Because the package isn't quite ready for release, it's not yet available on Packagist, so the information below isn't strictly correct.

The package should be installed using [Composer](https://getcomposer.org/):

```bash
composer require lukaswhite/geonames
```

## Signing up for an Account

You'll need a Geonames account in order to use the web serice &mdash; you can [sign up here](http://www.geonames.org/login) to get your username.

## Using the Web Service Client

You'll probably want to add a `use` statement like this:

```php
use Lukaswhite\Geonames\Geonames;
```

Then you can create an instance like this:

```php
$service = new Geonames( 'USERNAME' );
```

A good practice is to obtain your username from the environment, for example:
 
```php
$service = new Geonames( getenv( 'GEONAMES_USERNAME' ) );
``` 

> The [PHP dotenv](https://github.com/vlucas/phpdotenv) package is a great way of managing your environment variables

## Getting a Feature by its ID

Let's start with a really simple example &mdash; getting a Geonames feature by its ID.

```php
$england = $service->get( 6269131 );
print $england->getName( ); // outputs "England"
```

## Search

First, create a search query:

```php
use Lukaswhite\Geonames\Query\Search;

$query = new Search( );

```

Now use the class' numerous methods to build your query:

```php
// Search for France
$results = $search
    ->name( 'France' )
    ->filterByFeatureCode( 'PCLI' )
    ->limit( 5 );
    
print $results->count( );
    
foreach( $results as $feature ) {
    print $feature->getName( );
}
```

Here's another example; finding the largest cities and towns in the United Kingdom:

```php
$search
    ->inCountry( 'GB' )
    ->filterByFeatureCode( 'PPLC', 'PPLA', 'PPLA2' )
    ->orderByPopulation( )
    ->full( )
    ->limit( 25 );
```


