# Hierarchies

Hierarchies in Geonames model the way places are divided up, and the relationship between them.

They're probably best explained with the help of a couple of illustrations.
 
Consider the United Kingdom. 
 
![The United Kingdom](/_media/united-kingdom.png)
 
The United Kingdom is comprised of England, Wales, Scotland and Northern Ireland; i.e. they are the **children** of the United Kingdom. Wales, Scotland and Northern Ireland are the **siblings** of England.

Let's look at a more detailed examples.

<img src="/_media/barnet-hierarchy.svg" width="600">
 
!> The labels show name, feature class and then feature code. The value in brackets is the Geonames ID.

This illustrates the town of Barnet (P / PPL), which is in a borough with the same name (A / ADM3), which in turn is in the county of Greater London (A / ADM2). London is, of course, in England (A / ADM2) which in turn is in the United Kingdom (A / PCLI). That's in the continent of Europe (L / CONT) which is on planet Earth (L / AREA).

```xml
<?xml version="1.0" encoding="UTF-8"?>
<geonames>
   <geoname>
      <toponymName>Earth</toponymName>
      <name>Earth</name>
      <lat>0</lat>
      <lng>0</lng>
      <geonameId>6295630</geonameId>
      <countryCode />
      <countryName />
      <fcl>L</fcl>
      <fcode>AREA</fcode>
   </geoname>
   <geoname>
      <toponymName>Europe</toponymName>
      <name>Europe</name>
      <lat>48.69096</lat>
      <lng>9.14062</lng>
      <geonameId>6255148</geonameId>
      <countryCode />
      <countryName />
      <fcl>L</fcl>
      <fcode>CONT</fcode>
   </geoname>
   <geoname>
      <toponymName>United Kingdom of Great Britain and Northern Ireland</toponymName>
      <name>United Kingdom</name>
      <lat>54.75844</lat>
      <lng>-2.69531</lng>
      <geonameId>2635167</geonameId>
      <countryCode>GB</countryCode>
      <countryName>United Kingdom</countryName>
      <fcl>A</fcl>
      <fcode>PCLI</fcode>
   </geoname>
   <geoname>
      <toponymName>England</toponymName>
      <name>England</name>
      <lat>52.16045</lat>
      <lng>-0.70312</lng>
      <geonameId>6269131</geonameId>
      <countryCode>GB</countryCode>
      <countryName>United Kingdom</countryName>
      <fcl>A</fcl>
      <fcode>ADM1</fcode>
   </geoname>
   <geoname>
      <toponymName>Greater London</toponymName>
      <name>Greater London</name>
      <lat>51.5</lat>
      <lng>-0.16667</lng>
      <geonameId>2648110</geonameId>
      <countryCode>GB</countryCode>
      <countryName>United Kingdom</countryName>
      <fcl>A</fcl>
      <fcode>ADM2</fcode>
   </geoname>
   <geoname>
      <toponymName>Barnet</toponymName>
      <name>Barnet</name>
      <lat>51.65736</lat>
      <lng>-0.21423</lng>
      <geonameId>3333121</geonameId>
      <countryCode>GB</countryCode>
      <countryName>United Kingdom</countryName>
      <fcl>A</fcl>
      <fcode>ADM3</fcode>
   </geoname>
   <geoname>
      <toponymName>Barnet</toponymName>
      <name>Barnet</name>
      <lat>51.65</lat>
      <lng>-0.2</lng>
      <geonameId>2656295</geonameId>
      <countryCode>GB</countryCode>
      <countryName>United Kingdom</countryName>
      <fcl>P</fcl>
      <fcode>PPL</fcode>
   </geoname>
</geonames>
```