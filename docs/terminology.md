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