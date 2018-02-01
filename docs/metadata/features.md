# Features Metadata

The Features metadata class encapsulates information about feature codes and feature classes.

## Basic Usage

```php
use Lukaswhite\Geonames\Meta\Features;

$features = new Features( );
```

This loads the data from the `featureCodes_en.txt` file in the `data` folder.

?> The most up-to-date version of that file [can be found here](http://download.geonames.org/export/dump/featureCodes_en.txt). The same file is available in other languages [from the download server](http://download.geonames.org/export/dump/). 

If you want to override that, simply pass the filepath as an argument.

## Get a Feature Class

```php
$featureClass = $features->getClass( 'A' );
print $featureClass->getName( ); // outputs "country, state, region,..."
```

## Get the Feature Codes belonging to a Feature Class

```php
$featureCodes = $features->getClass( 'A' )->getCodes( );
```

## Get a Feature Code

```php
$featureCode = $features->getClass( 'A' )->getCode( 'ADM1' );

// or
$featureCode = $features->getCode( 'A.ADM1' );

// or
$featureCode = $features->getCode( 'ADM1' );

print $featureCode->getName( );
// outputs "first-order administrative division"

print $featureCode->getDescription( );
// outputs "a primary administrative division of a country, such as a state in the United States"
```

## Get all Feature Codes

```php
$all = $features->toArray( )
```

This returns an array of all codes; the colums are:

`Feature Class | Feature Code | Name | (optional) Description`

For example:

|Feature Class   |Feature Code   |Name   |Description   |
|---|---|---|---|
|A   |ADM1   |first-order administrative division   |a primary administrative division of a country, such as a state in the United States   |
|A   |ADM2   |second-order administrative division   |a subdivision of a first-order administrative division   |
|A   |PCLI   |independent political entity   |&nbsp;   |

etc