# Terminology

In order to make effective use of Geonames data, there are some terms it's important to understand.

## Features

In Geonames a feature is basically any geographical feature that's been given a name. That's incredibly wide ranging; a feture might be:

* A country
* A county or state
* A town, city or village
* A mountain or mountain range
* A river, lake or stream
* A railway station

## Feature Classes

Features are broadly divided into feature classes, which are single letters:

* **A** country, state, region,...
* **H** stream, lake, region,...
* **L** parks, area,...
* **P** city, village,...
* **R** road, railroad
* **S** spot, building, farm
* **T** mountain, hill, rock,...
* **U** undersea
* **V** forest, heath,...

## Feature Codes

Features are also divided by feature codes, which are essentially sub-divisions of feature classes.

Here are some examples:

* **A** country, state, region,...
    * **ADM1** A first-order administrative division; for example a country
    * **ADM2** A second-order administrative division; for example a county or state
* **P** city, village,...
    * **PPL** A populated place; e.g. a city, town, village
    * **PPLC** A capital city
* **S** spot, building, farm
    * **RSTN** A railway station
* **T** mountain, hill, rock,...
    * **MT** A mountain
    
    
> You'll find a [complete list here](http://www.geonames.org/export/codes.html)

## Administrative Divisions

A administrative division is some sort of geographical sub-division, typically political. Examples include counties, states, cantons, boroughs, provinces, municipalities, districts, prefectures and many more. 

Since the terminology can vary so significantly from country-to-country, their names are standardised somewhat with the user of the term "Administrative division".

?> The term administrative division is synonymous with administrative area  

There are a number of "levels" of administrative divisions; the higher the number, the smaller it is in relation to its parent. In other words an administrative division with a level of 1 might be broken up into multiple administrative divisions with the level 2, which in turn might be brokwn up into several more at level 3.
 
Take the example of the Borough of Barnet in Greater London, which in turn is in England; an administrative division of the country of the United Kingdom.

<img src="/_media/barnet-hierarchy-2.svg" width="400">

In this example, the administraive divisions of the United Kingdom are England (Level one, Feature code ADM1), Greater London (Level two, ADM2) and Barnet (Level three, ADM3) respectively. 
 
Administrative divisions have a code; for example `ENG` for England, `GLA` for Greater London and `A3` for Barnet. 
 
Information about administrative divisions is typically included when you request information about, or search on features. Often you may only get the admmin code; you'll typically need to set the stle (verbosity) to `FULL` to get the name. For the purposes of searching, the code is probably all you need. 

[Read more on Wikipedia](https://en.wikipedia.org/wiki/Administrative_division)

## Style

Style is used to specify how much information to return; i.e. verbosity. It's used, for example, when performing a search.

There are four styles:

* `SHORT`
* `MEDIUM`
* `LONG`
* `FULL`

For example, when searching features:

* `SHORT` will return the Geoname ID, name, toponym name, latitude / longitude, country code, feature class and feature code.
* `MEDIUM` will return all of the information as returned using the `SHORT` style plus the country name.
* `LONG` will return all of the information as returned using the `MEDIUM` style plus the name of the feature class, the name of the feature code, and the population.
* `FULL` will return all of the information as returned using the `MEDIUM` style plus the ASCII name, the alternate names, the elevation (including the srtm3 and astergdem) models, the admin codes and their names, the timezone, the bounding box and the relevance score. 


For more information, visit [this page](/styles).