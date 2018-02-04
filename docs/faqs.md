# FAQs (Frequently Asked Questions)

## Why isn't this available on Packagist?
 
Because it's not finished. Soon!
 
## Why are there gaps in the documentation?
 
See above.

## What can I use this package for?

The possibilities are almost endless.

Here are some examples:

* Maintaining a database of towns and cities
* A gazeteer
* A Postal code finder
* Find my nearest town / city / railway station

## All the information is available for download, why use the web service?

There were a couple of reasons I placed the emphasis on the web service, rather than the data that's available for download.

Firstly the amount of data available for download is vast, and very often overkill for a lot of purposes. As an example, suppose you just want records of towns and cities of a certain size (let's say a minium population of 5,000) in the United Kingdom. There are approximately 1,600 of them; even just the country-specific download file contains over 60,000 rows, which is quite a lot to work with all things considered. Grabbing the data via teh API is considerably easier and more efficient.
 
The second is that for a lot of purposes, the web service is a perfectly adaquate alternative to building something &mdash; let's say, a "find my nearest city" service &mdash; than trying to build your own, depending on the project. KISS.  

## Why isn't [web service] implemented in this library?

There are (at time of writing) [forty-one](http://www.geonames.org/export/ws-overview.html) different services provided. That's a lot! Right now it's partly an issue of time, but also an acknowledgement that I personally am never likely to use half of them.

However, [pull requests](https://github.com/lukaswhite/geonames-php/pulls) are always welcome.

## Why create your own Coordinate and BoundingBox model, when the PHP League's Geotools library already provides them?

[Geotools](https://github.com/thephpleague/geotools#geotools) is a great library, which I use a lot; and it does indeed provide a `Coordinate` and `BoundingBox` model, both of which are remarkably similar to the ones in mine.

Two things, though;

1. In this library, those two models don't really need very much functionality at all.
2. The library has a fair few dependencies, and I wanted to try to keep those to a minimum. In particular the Geotools library depends on the Symfony Console package, and I know from frustrating experience that that the version of that can cause all sorts of compatability issues, particulary when integrating with Laravel, which in turn uses that same library.
 
## Why not use Laravel's Collections class for results?
 
Again, this was about trying to minimise the dependencies.
 
It's really easy to use them in your own projects, though. Probably something like this:
 
```php
$results = collect( $service->run( // your query // )->toArray( ) );
``` 

## I have a suggestion or comment

Great &mdash; feel free to get in touch.