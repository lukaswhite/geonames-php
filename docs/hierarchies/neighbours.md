# Neighbours

?> You'll find the web services documentation [here](http://www.geonames.org/export/place-hierarchy.html).

!> This service is currently only available for countries.

This service will give you the neighbours of a place.

For example, let's take Switzerland as an example:

![Switzerland](/_media/switzerland.png)

```php
use Lukaswhite\Geonames\Query\Hierarchy\Neighbours;

$results = $service->run( new Neighbours( 2658434 ) );

$names = $results->map( function( $item ) {
    return $item->getName( );
} )->toArray( );

printf(
    'Switzerland has %s as neighbours',
    implode( ', ', $names )
); // prints "Switzerland has Austria, France, Germany, Italy, Liechtenstein as neighbours"
```

> You can control the amount of information returned by modifying the style.

The raw results of this query are displayed below.

```xml
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<geonames style="MEDIUM">
    <totalResultsCount>5</totalResultsCount>
    <geoname>
        <toponymName>Republic of Austria</toponymName>
        <name>Austria</name>
        <lat>47.33333</lat>
        <lng>13.33333</lng>
        <geonameId>2782113</geonameId>
        <countryCode>AT</countryCode>
        <countryName>Austria</countryName>
        <fcl>A</fcl>
        <fcode>PCLI</fcode>
    </geoname>
    <geoname>
        <toponymName>Republic of France</toponymName>
        <name>France</name>
        <lat>46</lat>
        <lng>2</lng>
        <geonameId>3017382</geonameId>
        <countryCode>FR</countryCode>
        <countryName>France</countryName>
        <fcl>A</fcl>
        <fcode>PCLI</fcode>
    </geoname>
    <geoname>
        <toponymName>Federal Republic of Germany</toponymName>
        <name>Germany</name>
        <lat>51.5</lat>
        <lng>10.5</lng>
        <geonameId>2921044</geonameId>
        <countryCode>DE</countryCode>
        <countryName>Germany</countryName>
        <fcl>A</fcl>
        <fcode>PCLI</fcode>
    </geoname>
    <geoname>
        <toponymName>Repubblica Italiana</toponymName>
        <name>Italy</name>
        <lat>42.83333</lat>
        <lng>12.83333</lng>
        <geonameId>3175395</geonameId>
        <countryCode>IT</countryCode>
        <countryName>Italy</countryName>
        <fcl>A</fcl>
        <fcode>PCLI</fcode>
    </geoname>
    <geoname>
        <toponymName>Principality of Liechtenstein</toponymName>
        <name>Liechtenstein</name>
        <lat>47.16667</lat>
        <lng>9.53333</lng>
        <geonameId>3042058</geonameId>
        <countryCode>LI</countryCode>
        <countryName>Liechtenstein</countryName>
        <fcl>A</fcl>
        <fcode>PCLI</fcode>
    </geoname>
</geonames>

```