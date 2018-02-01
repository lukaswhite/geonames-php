# Quick Start

## Installation

!> Because the package isn't quite ready for release, it's not yet available on Packagist, so the information below isn't strictly correct.

The package should be installed using [Composer](https://getcomposer.org/):

```bash
composer require lukaswhite/geonames
```

## Signing up for an Account

!> You'll need a Geonames account in order to use the web serice &mdash; you can [sign up here](http://www.geonames.org/login) to get your username.

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

### How do I know the ID?

It's all very well being able to get details about a feature / place by its Geonames ID, but you need to know it first. That's covered in much greater detail throughout; search is one way, hierarchies are another.

For now, here are some IDs you might want to play around with:

|Name   |Geonames ID   |Feature Class   |Feature Code   |
|---|---|---|---|
|Europe   |6255148   |L   |CONT   |
|North America   |6255149   |L   |CONT   |
|United Kingdom   |2635167   |A   |PCLI   |
|England   |6269131   |A   |ADM1   |
|Greater London   |2648110   |A   |ADM2   |
|Texas   |4736286   |A   |ADM1   |
|France   |3017382   |A   |PCLI   |
|Germany   |2921044   |A   |PCLI   |
|Italy   |3175395   |A   |PCLI   |
|Switzerland   |2658434   |A   |PCLI   |


## Search

First, create a search query:

```php
use Lukaswhite\Geonames\Query\Search;

$query = new Search( );

```

Now use the class' numerous methods to build your query:

```php
// Search for France
$query
    ->name( 'France' )
    ->filterByFeatureCode( 'PCLI' )
    ->limit( 5 );
```
    
To run the search:
    
```php    
$results = $service->run( $query );    
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