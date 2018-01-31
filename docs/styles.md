# Styles

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


## By Example

To further illustrate the impact of modifying the style, here are some example search results for different styles.
 
> Bear in mind you should never need to worry about the raw XML or JSON results! 

### SHORT

```
http://api.geonames.org/search?q=london&maxRows=1&username=demo&style=SHORT
```

```xml
<?xml version="1.0" encoding="UTF-8"?>
<geonames style="SHORT">
   <totalResultsCount>7176</totalResultsCount>
   <geoname>
      <toponymName>London</toponymName>
      <name>London</name>
      <lat>51.50853</lat>
      <lng>-0.12574</lng>
      <geonameId>2643743</geonameId>
      <countryCode>GB</countryCode>
      <fcl>P</fcl>
      <fcode>PPLC</fcode>
   </geoname>
</geonames>
```

### MEDIUM

```
http://api.geonames.org/search?q=london&maxRows=1&username=demo&style=MEDIUM
```

```xml
<?xml version="1.0" encoding="UTF-8"?>
<geonames style="MEDIUM">
   <totalResultsCount>7176</totalResultsCount>
   <geoname>
      <toponymName>London</toponymName>
      <name>London</name>
      <lat>51.50853</lat>
      <lng>-0.12574</lng>
      <geonameId>2643743</geonameId>
      <countryCode>GB</countryCode>
      <countryName>United Kingdom</countryName>
      <fcl>P</fcl>
      <fcode>PPLC</fcode>
   </geoname>
</geonames>
```

### LONG

```
http://api.geonames.org/search?q=london&maxRows=1&username=demo&style=LONG
```

```xml
<?xml version="1.0" encoding="UTF-8"?>
<geonames style="LONG">
   <totalResultsCount>7176</totalResultsCount>
   <geoname>
      <toponymName>London</toponymName>
      <name>London</name>
      <lat>51.50853</lat>
      <lng>-0.12574</lng>
      <geonameId>2643743</geonameId>
      <countryCode>GB</countryCode>
      <countryName>United Kingdom</countryName>
      <fcl>P</fcl>
      <fcode>PPLC</fcode>
      <fclName>city, village,...</fclName>
      <fcodeName>capital of a political entity</fcodeName>
      <population>7556900</population>
   </geoname>
</geonames>
```

### FULL

```
http://api.geonames.org/search?q=london&maxRows=1&username=demo&style=FULL
```

```xml
<?xml version="1.0" encoding="UTF-8"?>
<geonames style="FULL">
   <totalResultsCount>7176</totalResultsCount>
   <geoname>
      <toponymName>London</toponymName>
      <name>London</name>
      <lat>51.50853</lat>
      <lng>-0.12574</lng>
      <geonameId>2643743</geonameId>
      <countryCode>GB</countryCode>
      <countryName>United Kingdom</countryName>
      <fcl>P</fcl>
      <fcode>PPLC</fcode>
      <fclName>city, village,...</fclName>
      <fcodeName>capital of a political entity</fcodeName>
      <population>7556900</population>
      <asciiName>London</asciiName>
      <alternateNames>Gorad Londan,ILondon,LON,Lakana,Landan,Landen,Ljondan,Llundain,Lodoni,Londain,Londan,Londar,Londe,Londen,Londin,Londinium,Londino,Londn,London,London osh,Londona,Londonas,Londoni,Londono,Londons,Londonu,Londra,Londres,Londrez,Londri,Londro,Londye,Londyn,Londýn,Lonn,Lontoo,Loundres,Luan GJon,Lun-tun,Lunden,Lundra,Lundun,Lundunir,Lundúnir,Lung-dung,Lunnainn,Lunnin,Lunnon,Luân Đôn,Lùn-tûn,Lùng-dŭng,Lûn-tun,Lākana,Lůndůn,Lọndọnu,Ranana,Rānana,ilantan,ladana,landan,landana,leondeon,lndn,london,londoni,lun dui,lun dun,lwndwn,lxndxn,rondon,Łondra,Λονδίνο,Горад Лондан,Лондан,Лондон,Лондон ош,Лондонъ,Лёндан,Լոնդոն,לאנדאן,לונדון,لأندأن,لندن,لوندون,لەندەن,ܠܘܢܕܘܢ,लंडन,लंदन,लण्डन,लन्डन्,लन्दन,লন্ডন,ਲੰਡਨ,લંડન,ଲଣ୍ଡନ,இலண்டன்,లండన్,ಲಂಡನ್,ലണ്ടൻ,ලන්ඩන්,ลอนดอน,ລອນດອນ,ལོན་ཊོན།,လန်ဒန်မြို့,ლონდონი,ለንደን,ᎫᎴ ᏗᏍᎪᏂᎯᏱ,ロンドン,伦敦,倫敦,런던</alternateNames>
      <elevation />
      <srtm3>25</srtm3>
      <astergdem>33</astergdem>
      <continentCode>EU</continentCode>
      <adminCode1 ISO3166-2="ENG">ENG</adminCode1>
      <adminName1>England</adminName1>
      <adminCode2>GLA</adminCode2>
      <adminName2>Greater London</adminName2>
      <alternateName lang="ab">Лондан</alternateName>
      <alternateName lang="af">Londen</alternateName>
      <alternateName lang="als">London</alternateName>
      <alternateName lang="am">ለንደን</alternateName>
      <alternateName lang="an">Londres</alternateName>
      <alternateName lang="ang">Lunden</alternateName>
      <alternateName lang="ar">لندن</alternateName>
      <alternateName lang="arc">ܠܘܢܕܘܢ</alternateName>
      <alternateName lang="arz">لندن</alternateName>
      <alternateName lang="ast">Londres</alternateName>
      <alternateName lang="az">London</alternateName>
      <alternateName lang="azb">لندن</alternateName>
      <alternateName lang="ba">Лондон</alternateName>
      <alternateName lang="bcl">Londres</alternateName>
      <alternateName lang="be">Лёндан</alternateName>
      <alternateName lang="bg">Лондон</alternateName>
      <alternateName lang="bh">लंदन</alternateName>
      <alternateName lang="bn">লন্ডন</alternateName>
      <alternateName lang="bo">ལོན་ཊོན།</alternateName>
      <alternateName lang="br">Londrez</alternateName>
      <alternateName lang="bs">London</alternateName>
      <alternateName lang="bxr">Лондон</alternateName>
      <alternateName lang="ca">Londres</alternateName>
      <alternateName lang="cdo">Lùng-dŭng</alternateName>
      <alternateName lang="ce">Лондон</alternateName>
      <alternateName lang="chr">ᎫᎴ ᏗᏍᎪᏂᎯᏱ</alternateName>
      <alternateName lang="ckb">لەندەن</alternateName>
      <alternateName lang="co">Londra</alternateName>
      <alternateName lang="cs">Londýn</alternateName>
      <alternateName lang="csb">Londin</alternateName>
      <alternateName lang="cu">Лондонъ</alternateName>
      <alternateName lang="cv">Лондон</alternateName>
      <alternateName lang="cy">Llundain</alternateName>
      <alternateName lang="da">London</alternateName>
      <alternateName lang="de">London</alternateName>
      <alternateName lang="diq">Londra</alternateName>
      <alternateName lang="el">Λονδίνο</alternateName>
      <alternateName isPreferredName="true" lang="en">London</alternateName>
      <alternateName lang="eo">Londono</alternateName>
      <alternateName lang="es">Londres</alternateName>
      <alternateName lang="et">London</alternateName>
      <alternateName lang="eu">Londres</alternateName>
      <alternateName lang="ext">Londri</alternateName>
      <alternateName lang="fa">لندن</alternateName>
      <alternateName lang="fi">Lontoo</alternateName>
      <alternateName lang="fj">Lodoni</alternateName>
      <alternateName isPreferredName="true" isShortName="true" lang="fr">Londres</alternateName>
      <alternateName lang="frp">Londro</alternateName>
      <alternateName lang="fy">Londen</alternateName>
      <alternateName lang="ga">Londain</alternateName>
      <alternateName lang="gan">倫敦</alternateName>
      <alternateName lang="gd">Lunnainn</alternateName>
      <alternateName lang="gl">Londres</alternateName>
      <alternateName lang="gn">Londye</alternateName>
      <alternateName lang="gu">લંડન</alternateName>
      <alternateName lang="gv">Lunnin</alternateName>
      <alternateName lang="hak">Lùn-tûn</alternateName>
      <alternateName lang="haw">Lākana</alternateName>
      <alternateName lang="hbs">London</alternateName>
      <alternateName lang="he">לונדון</alternateName>
      <alternateName lang="hi">लंदन</alternateName>
      <alternateName lang="hr">London</alternateName>
      <alternateName lang="ht">Lonn</alternateName>
      <alternateName lang="hu">London</alternateName>
      <alternateName lang="hy">Լոնդոն</alternateName>
      <alternateName lang="ia">London</alternateName>
      <alternateName lang="iata">LON</alternateName>
      <alternateName lang="id">London</alternateName>
      <alternateName lang="ilo">Londres</alternateName>
      <alternateName lang="io">London</alternateName>
      <alternateName lang="is">Lundúnir</alternateName>
      <alternateName lang="it">Londra</alternateName>
      <alternateName lang="ja">ロンドン</alternateName>
      <alternateName lang="jbo">london</alternateName>
      <alternateName lang="ka">ლონდონი</alternateName>
      <alternateName lang="kbd">Лондон</alternateName>
      <alternateName lang="kk">Лондон</alternateName>
      <alternateName lang="kn">ಲಂಡನ್</alternateName>
      <alternateName lang="ko">런던</alternateName>
      <alternateName lang="koi">Лондон</alternateName>
      <alternateName lang="krc">Лондон</alternateName>
      <alternateName lang="ku">London</alternateName>
      <alternateName lang="kv">Лондон</alternateName>
      <alternateName lang="kw">Loundres</alternateName>
      <alternateName lang="ky">Лондон</alternateName>
      <alternateName lang="la">Londinium</alternateName>
      <alternateName lang="lad">Londra</alternateName>
      <alternateName lang="lb">London</alternateName>
      <alternateName lang="lbe">Лондон</alternateName>
      <alternateName lang="lez">Лондон</alternateName>
      <alternateName lang="li">Londe</alternateName>
      <alternateName lang="lij">Londra</alternateName>
      <alternateName lang="link">http://en.wikipedia.org/wiki/London</alternateName>
      <alternateName lang="lmo">Lundra</alternateName>
      <alternateName lang="ln">Londoni</alternateName>
      <alternateName lang="lo">ລອນດອນ</alternateName>
      <alternateName lang="lrc">لأندأن</alternateName>
      <alternateName lang="lt">Londonas</alternateName>
      <alternateName lang="lv">Londona</alternateName>
      <alternateName lang="lzh">倫敦</alternateName>
      <alternateName lang="mai">लण्डन</alternateName>
      <alternateName lang="mhr">Лондон</alternateName>
      <alternateName lang="mi">Rānana</alternateName>
      <alternateName lang="mk">Лондон</alternateName>
      <alternateName lang="ml">ലണ്ടൻ</alternateName>
      <alternateName lang="mn">Лондон</alternateName>
      <alternateName lang="mr">लंडन</alternateName>
      <alternateName lang="mrj">Лондон</alternateName>
      <alternateName lang="ms">London</alternateName>
      <alternateName lang="mt">Londra</alternateName>
      <alternateName lang="mwl">Londres</alternateName>
      <alternateName lang="my">လန်ဒန်မြို့</alternateName>
      <alternateName lang="myv">Лондон ош</alternateName>
      <alternateName lang="mzn">لندن</alternateName>
      <alternateName lang="nah">Londres</alternateName>
      <alternateName lang="nan">Lûn-tun</alternateName>
      <alternateName lang="nap">Londra</alternateName>
      <alternateName lang="nds">London</alternateName>
      <alternateName lang="ne">लण्डन</alternateName>
      <alternateName lang="new">लन्दन</alternateName>
      <alternateName lang="nl">Londen</alternateName>
      <alternateName lang="nn">London</alternateName>
      <alternateName lang="no">London</alternateName>
      <alternateName lang="nrm">Londres</alternateName>
      <alternateName lang="oc">Londres</alternateName>
      <alternateName lang="om">Landan</alternateName>
      <alternateName lang="or">ଲଣ୍ଡନ</alternateName>
      <alternateName lang="os">Лондон</alternateName>
      <alternateName lang="pa">ਲੰਡਨ</alternateName>
      <alternateName lang="pcd">Londe</alternateName>
      <alternateName lang="pl">Londyn</alternateName>
      <alternateName lang="pms">Londra</alternateName>
      <alternateName lang="pnb">لندن</alternateName>
      <alternateName lang="pnt">Λονδίνο</alternateName>
      <alternateName lang="ps">لندن</alternateName>
      <alternateName lang="pt">Londres</alternateName>
      <alternateName lang="qu">London</alternateName>
      <alternateName lang="rm">Londra</alternateName>
      <alternateName lang="ro">Londra</alternateName>
      <alternateName lang="ru">Лондон</alternateName>
      <alternateName lang="rue">Лондон</alternateName>
      <alternateName lang="sa">लन्डन्</alternateName>
      <alternateName lang="sah">Лондон</alternateName>
      <alternateName lang="sc">Londra</alternateName>
      <alternateName lang="scn">Londra</alternateName>
      <alternateName lang="sco">Lunnon</alternateName>
      <alternateName lang="sgs">Londons</alternateName>
      <alternateName lang="si">ලන්ඩන්</alternateName>
      <alternateName lang="sk">Londýn</alternateName>
      <alternateName lang="sl">London</alternateName>
      <alternateName lang="sq">Londra</alternateName>
      <alternateName lang="sr">Лондон</alternateName>
      <alternateName lang="sv">London</alternateName>
      <alternateName lang="szl">Lůndůn</alternateName>
      <alternateName lang="ta">இலண்டன்</alternateName>
      <alternateName lang="te">లండన్</alternateName>
      <alternateName lang="tet">Londres</alternateName>
      <alternateName lang="tg">Лондон</alternateName>
      <alternateName lang="th">ลอนดอน</alternateName>
      <alternateName lang="tl">Londres</alternateName>
      <alternateName lang="tpi">Landen</alternateName>
      <alternateName lang="tr">Londra</alternateName>
      <alternateName lang="tt">Лондон</alternateName>
      <alternateName lang="udm">Лондон</alternateName>
      <alternateName lang="ug">لوندون</alternateName>
      <alternateName lang="uk">Лондон</alternateName>
      <alternateName lang="unlc">LON</alternateName>
      <alternateName lang="ur">لندن</alternateName>
      <alternateName lang="vec">Łondra</alternateName>
      <alternateName lang="vi">Luân Đôn</alternateName>
      <alternateName lang="vls">Londn</alternateName>
      <alternateName lang="vo">London</alternateName>
      <alternateName lang="wo">Londar</alternateName>
      <alternateName lang="wuu">伦敦</alternateName>
      <alternateName lang="xmf">ლონდონი</alternateName>
      <alternateName lang="yi">לאנדאן</alternateName>
      <alternateName lang="yo">Lọndọnu</alternateName>
      <alternateName lang="yue">倫敦</alternateName>
      <alternateName lang="zea">Londen</alternateName>
      <alternateName lang="zh">伦敦</alternateName>
      <alternateName lang="zh-CN">伦敦</alternateName>
      <alternateName lang="zu">ILondon</alternateName>
      <timezone dstOffset="1.0" gmtOffset="0.0">Europe/London</timezone>
      <bbox>
         <west>-0.49916</west>
         <north>51.68293</north>
         <east>0.28119</east>
         <south>51.29752</south>
         <accuracyLevel>10</accuracyLevel>
      </bbox>
      <score>135.35345458984375</score>
   </geoname>
</geonames>
```