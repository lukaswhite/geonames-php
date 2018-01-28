<?php

use Lukaswhite\Geonames\Models\Feature;

class MapperTest extends PHPUnit_Framework_TestCase{

    public function testShortXml( )
    {
        $str = file_get_contents(
            sprintf(
                '%s%sfixtures%s%s%s%s',
                __DIR__,
                DIRECTORY_SEPARATOR,
                DIRECTORY_SEPARATOR,
                'search',
                DIRECTORY_SEPARATOR,
                'results-short.xml'
            )
        );

        $results = \Lukaswhite\Geonames\Mappers\Xml::geonames( simplexml_load_string( $str ) );

        $this->assertInstanceOf( \Lukaswhite\Geonames\Results\Resultset::class, $results );

        $this->assertEquals( 64250, $results->total( ) );

        $uk = $results->getResults( )[ 1 ];
        $this->assertUkShort( $uk );
    }

    public function testMediumXml( )
    {
        $str = file_get_contents(
            sprintf(
                '%s%sfixtures%s%s%s%s',
                __DIR__,
                DIRECTORY_SEPARATOR,
                DIRECTORY_SEPARATOR,
                'search',
                DIRECTORY_SEPARATOR,
                'results-medium.xml'
            )
        );

        $results = \Lukaswhite\Geonames\Mappers\Xml::geonames( simplexml_load_string( $str ) );

        $this->assertInstanceOf( \Lukaswhite\Geonames\Results\Resultset::class, $results );

        $this->assertEquals( 64250, $results->total( ) );

        $uk = $results->getResults( )[ 1 ];
        $this->assertUkShort( $uk );

        // The country doesn't appear in the short version, but it does the medium
        $this->assertEquals( 'United Kingdom', $uk->getCountry( )->getName( ) );
    }

    public function testFullXml( )
    {
        $str = file_get_contents(
            sprintf(
                '%s%sfixtures%s%s%s%s',
                __DIR__,
                DIRECTORY_SEPARATOR,
                DIRECTORY_SEPARATOR,
                'search',
                DIRECTORY_SEPARATOR,
                'results-full.xml'
            )
        );

        $results = \Lukaswhite\Geonames\Mappers\Xml::geonames( simplexml_load_string( $str ) );

        $this->assertInstanceOf( \Lukaswhite\Geonames\Results\Resultset::class, $results );

        $this->assertEquals( 64250, $results->total( ) );

        $uk = $results->getResults( )[ 1 ];
        $this->assertUkShort( $uk );

        // The country doesn't appear in the short version, but it does the medium
        $this->assertEquals( 'United Kingdom', $uk->getCountry( )->getName( ) );
        $this->assertEquals( 'United Kingdom of Great Britain and Northern Ireland', $uk->getAsciiName( ) );
        $this->assertEquals( '00', $uk->getAdminCode1( ) );
        $this->assertEquals( 1, $uk->getAdminCodeLevel( ) );
        $this->assertEquals( \Lukaswhite\Geonames\Models\Continent::EUROPE, $uk->getContinentCode( ) );

        $this->assertEquals( 62348447, $uk->getPopulation( ) );
        $this->assertEquals( 71, $uk->getStrm3( ) );
        $this->assertEquals( 57, $uk->getAstergdem( ) );

        $this->assertNotNull( $uk->getBoundingBox( ) );
        $this->assertEquals( -8.65001, $uk->getBoundingBox( )->getWest( ) );
        $this->assertEquals( 60.84581, $uk->getBoundingBox( )->getNorth( ) );
        $this->assertEquals( 33.9175, $uk->getBoundingBox( )->getEast( ) );
        $this->assertEquals( -34.69046, $uk->getBoundingBox( )->getSouth( ) );

        $this->assertEquals( 'Europe/London', $uk->getTimezone( ) );

        $this->assertEquals( 146, count( $uk->getAlternateNames( ) ) );

        $am = $uk->getAlternateName( 'am' );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\AlternateName::class, $am );
        $this->assertEquals( 'am', $am->getLanguage( ) );
        $this->assertEquals( 'እንግሊዝ', $am->getName( ) );
        $this->assertFalse( $am->isPreferred( ) );
        $this->assertFalse( $am->isShort( ) );
        $this->assertFalse( $am->isLink( ) );
        $this->assertFalse( $am->isAbbreviation( ) );
        $this->assertFalse( $am->isPseudoLanguage( ) );

        $ak = $uk->getAlternateName( 'ak' );
        $this->assertTrue( $ak->isPreferred( ) );

        $ak = $uk->getAlternateName( 'ak' );
        $this->assertTrue( $ak->isPreferred( ) );

        $lt = $uk->getAlternateName( 'lt' );
        $this->assertTrue( $lt->isShort( ) );

        $link = $uk->getAlternateName( 'link' );
        $this->assertTrue( $link->isLink( ) );
        $this->assertTrue( $link->isPseudoLanguage( ) );
        $this->assertEquals( 'http://en.wikipedia.org/wiki/United_Kingdom', $link->getName( ) );

        $london = $results->getResults( )[ 6 ];
        $this->assertEquals( 'London', $london->getName( ) );
        $this->assertEquals( 'ENG', $london->getAdminCode1( ) );
        $this->assertEquals( 'GLA', $london->getAdminCode2( ) );
        $this->assertEquals( 2, $london->getAdminCodeLevel( ) );

        $barnet = $results->getResults( )[ 90 ];
        $this->assertEquals( 'Barnet', $barnet->getName( ) );
        $this->assertEquals( 'ENG', $barnet->getAdminCode1( ) );
        $this->assertEquals( 'GLA', $barnet->getAdminCode2( ) );
        $this->assertEquals( 'A2', $barnet->getAdminCode3( ) );
        $this->assertEquals( 3, $barnet->getAdminCodeLevel( ) );

    }

/**

<fclName>country, state, region,...</fclName>
<fcodeName>independent political entity</fcodeName>
<asciiName>United Kingdom of Great Britain and Northern Ireland</asciiName>
<alternateNames>Ahendiman Nkabom,An Riocht Aontaithe,An Rioghachd Aonaichte,An Rìoghachd Aonaichte,An Ríocht Aontaithe,Angeletele,Angilɛtɛri,Angletera,Angɛlɛtɛ́lɛ,Apvienota Karaliste,Apvienotā Karaliste,Birlesik Krallik,Birleşik Krallık,Birləşmiş Krallıq,Birtaniya,Boeyuek Britaniya,Bretland,Britain,Britania Raya,Britannia,Britanniarum Regnum,Bungereza,Böyük Britaniya,Det Forenede Kongerige,Det Forenede Kongerige Storbritannien og Nordirland,Det forente kongerike Storbritannia og Nord-Irland,Didzioji Britanija,Didžioji Britanija,Egyesuelt Kiralysag,Egyesült Királyság,Enomeno Basileio,Erresuma Batua,Geaned Cynerice,Geāned Cynerīce,Grande-Bretagne,Great Britain,Groot-Brittanje,Groot-Brittannie,Groot-Brittannië,Grossbritannien,Grossbritannien und Nordirland,Groussbritannien,Groussbritannien an Nordirland,Großbritannien,Großbritannien und Nordirland,Grut-Brittanje,Hukllachasqa Qhapaq Suyu,Ing-guok,Inggris Raya,Ingiltere,Ingilterra,Jungtine Didziosios Britanijos ir Siaures Airijos Karalyste,Jungtine Karalyste,Jungtinė Didžiosios Britanijos ir Šiaurės Airijos Karalystė,Jungtinė Karalystė,Kerajaan Inggris,Keyaniya Yekbuyi,Keyaniya Yekbûyî,Keyatiya Yekbuyi ya Britaniya Mezin u Irlanda,Keyatiya Yekbûyî ya Brîtaniya Mezin û Îrlanda,Kingitanga Kotahi,Koedoeroegbiae--Oko,Ködörögbïä--Ôko,Kīngitanga Kotahi,Laamateeri Rentundi,Lielbritanija,Lielbritanijas un Ziemelirijas Apvienota Karaliste,Lielbritānija,Lielbritānijas un Ziemeļīrijas Apvienotā Karaliste,Marea Britanie,Mbreteria e Bashkuar,Mbreteria e Bashkuar e Britanise se Madhe dhe Irlandes se Veriut,Mbretëria e Bashkuar,Mbretëria e Bashkuar e Britanisë së Madhe dhe Irlandës së Veriut,Mec Britania,Nagkakaisang Kaharain,Nagkakaisang Kaharian,Nagkaykaysa a Pagarian,Ngeretha,Obedineno kralstvo,Obedineno kralstvo Velikobritanija i Severna Irlandija,Obedineto Kralstvo,Orileede Omobabirin,Orílẹ́ède Omobabirin,Paratane,Paratāne,Phandlo Thagaripen la Bare Britaniyako thai le Nordutne Irlandesko,Pilitania,Pilitānia,Pisanmetung a Ka-arian,Prydain Fawr,Reeriaght Unnaneysit,Regatul Unit al Marii Britanii si al Irlandei de Nord,Regatul Unit al Marii Britanii și al Irlandei de Nord,Reginavel Uni,Reginavel Uni da la Gronda Britannia ed Irlanda dal Nord,Reginavel Unì,Reginavel Unì da la Gronda Britannia ed Irlanda dal Nord,Regn Uni,Regn Unì,Regne Unit,Regne Unit de la Gran Bretanya i Irlanda del Nord,Regno Unio,Regno Unite,Regno Unito,Regno Unïo,Regnu Unitu,Regnum Unitum,Reialme Unit,Reiaume Unit,Reino Unido,Reino Unido - United Kingdom,Reino Unito,Reinu Naklibur,Reinu Uniu,Reinu Uníu,Reinu Xuniu,Reinu Xuníu,Renju Unit,Rouantelezh Unanet Breizh-Veur ha Norzhiwerzhon,Rouantelezh-Unanet,Rouoyaume Unni,Royaume-Uni,Royomo-Uni,Royômo-Uni,Rywvaneth Unys,Spojene kralovstvi,Spojene kralovstvo,Spojené království,Spojené kráľovstvo,Spolucene Korolivstvo,Stora Bretland,Stora-Bretland,Storbritannia,Storbritannien,Stuorra-Britannia,Stuorra-Británnia,Styr Britani,Stóra Bretland,Stóra-Bretland,Suurbritannia,Tuluit Nunaat,U.K.,UEhendkuningriik,UK,Ubwongereza,Uingereza,Ujedineno Kralevstvo,Ujedinjena Kraljevina,Ujedinjeno Kraljevstvo,Unionita Rejio,United Kingdom,United Kingdom nutome,United Kingdom of Great Britain and Northern Ireland,Unitit Kinrick,Unuiginta Reglando,Unuiĝinta Reĝlando,Vaeinigts Kinireich,Valikaa Brytania,Valikabrytania,Velika Britania,Velika Britanija,Velikabrytania,Velikobritania,Velikobritanija,Velka Britanie,Velká Británie,Vereenigt Koenigriek vun Grootbritannien un Noordirland,Vereenigt Königriek vun Grootbritannien un Noordirland,Vereineg Keuninkriek,Vereinigtes Koenigreich,Vereinigtes Königreich,Verenigd Koninkrijk,Verenigde Koninkryk,Vuong quoc Anh,Vuong quoc Lien hiep Anh va Bac Ireland,Vương quốc Anh,Vương quốc Liên hiệp Anh và Bắc Ireland,Wayom Ini,Wayòm Ini,Wielka Brytania,Y Deyrnas Unedig,Yhdistynyt kuningaskunta,Yhtys Kuningaskundu,Zdruzeno kraljestvo (V. Britanija in S. Irska),Zdruzeno kraljestvo Velike Britanije in Severne Irske,Združeno kraljestvo (V. Britanija in S. Irska),Združeno kraljestvo Velike Britanije in Severne Irske,Zjednocene kralestwo,Zjednoczone Krolestwo Wielkiej Brytanii,Zjednoczone Królestwo Wielkiej Brytanii,Zjednoćene kralestwo,aikkiya iracciyam,almmlkt almthdt,anglstan,britan,britan/inglend,britana,briten,brtanyh,brytanya,brytnyh,bۈyۈk bېrytanyyە,gaertianebuli samepo,gretabrtena,i-United Kingdom,igirisu,mlkwtʾ mhydtʾ,padshahy mthd brytanyay kbyr w ayrlnd shmaly,padshahy mthdh,piritis kuttaracu,pʼrʼyynygtʻ qʻnygryyk,sanyukta adhirajya,sanyukta raajya,sanyukta rajasahi,sh rach xanacakr,yeong-gug,ying guo,yuktarajya,yuna'iteda kingadama,Ühendkuningriik,Ĭng-guók,İngiltere,Ηνωμένο Βασίλειο,Бирлашган Қироллик,Велика Британија,Велика Британія,Великобритания,Великобританія,Велікабрытанія,Вялікабрытанія,Вялікая Брытанія,Обединено кралство,Обединено кралство Великобритания и Северна Ирландия,Обединето Кралство,Подшоҳии Муттаҳида,Сполучене Королівство,Стыр Британи,Уједињено Краљевство,Ұлыбритания,Մեծ Բրիտանիա,Միավորված Թագավորություն,Միացյալ Թագավորություն,בריטניה,הממלכה המאוחדת,פאראייניגטע קעניגרייך,المملكة المتحدة,انگلستان,برتانیه,برطانیہ,بريتانيا,بریتانیا,بۈيۈك بېرىتانىيە,سلطنت متحدہ,شانشینی یەکگرتوو,پادشاهی متحد بریتانیای کبیر و ایرلند شمالی,پادشاهی متحده,ܡܠܟܘܬܐ ܡܚܝܕܬܐ,ब्रिटन,ब्रितन,संयुक्त अधिराज्य,संयुक्त राजशाही,গ্রেটবৃটেন,যুক্তরাজ্য,সংযুক্ত ৰাজ্য,યુનાઇટેડ કિંગડમ,ବ୍ରିଟେନ୍,ஐக்கிய இராச்சியம்,பிரிடிஷ் கூட்டரசு,బ్రిటన్,ಬ್ರಿಟನ್/ಇಂಗ್ಲೆಂಡ್,ബ്രിട്ടന്‍,එක්සත් රාජධානිය,สหราชอาณาจักร,ສະຫະລາດຊະອານາຈັກ,དབྱིན་ཇི་,ཡུ་ནའི་ཊེཊ་ཀིང་ཌམ,ယူနိုက်တက်ကင်းဒမ်း,გაერთიანებული სამეფო,დიდი ბრიტანეთი,እንግሊዝ,ዩናይትድ ኪንግደም,イギリス,英国,ꑱꇩ,영국</alternateNames>

        <timezone dstOffset="1.0" gmtOffset="0.0">Europe/London</timezone>
        <bbox>
            <west>-8.65001</west>
            <north>60.84581</north>
            <east>33.9175</east>
            <south>-34.69046</south>
            <accuracyLevel>10</accuracyLevel>
        </bbox>
 **/

    public function testPostalCodes( )
    {
        $str = file_get_contents(
            sprintf(
                '%s%sfixtures%s%s%s%s',
                __DIR__,
                DIRECTORY_SEPARATOR,
                DIRECTORY_SEPARATOR,
                'postcodes',
                DIRECTORY_SEPARATOR,
                'manchester.xml'
            )
        );

        $results = \Lukaswhite\Geonames\Mappers\Xml::codes( simplexml_load_string( $str ) );

        $this->assertInstanceOf( \Lukaswhite\Geonames\Results\Resultset::class, $results );

        $m3 = $results->getResults( )[ 0 ];
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\PostalCode::class, $m3 );
        $this->assertEquals( 'M3', $m3->getPostalCode( ) );
        $this->assertEquals( 'M3', $m3->__toString( ) );
        $this->assertEquals( 'M3', ( string ) $m3 );
        $this->assertEquals( 'Manchester', $m3->getName( ) );
        $this->assertEquals( 'GB', $m3->getCountryCode( ) );
        $this->assertEquals( 'ENG', $m3->getAdminCode1( ) );
        $this->assertEquals( 'England', $m3->getAdminName1( ) );
        $this->assertEquals( '2648108', $m3->getAdminCode2( ) );
        $this->assertEquals( 'Greater Manchester', $m3->getAdminName2( ) );
        $this->assertEquals( '', $m3->getAdminName3( ) );
        $this->assertEquals( 2, $m3->getAdminCodeLevel( ) );
        $this->assertEquals( 0.00048, $m3->getDistance( ) );
        $this->assertEquals( 53.48095, $m3->getLatitude( ) );
        $this->assertEquals( -2.23743, $m3->getLongitude( ) );

    }

    public function testMappingAddress( )
    {
        $str = file_get_contents(
            sprintf(
                '%s%sfixtures%s%s%s%s',
                __DIR__,
                DIRECTORY_SEPARATOR,
                DIRECTORY_SEPARATOR,
                'nearby',
                DIRECTORY_SEPARATOR,
                'address.xml'
            )
        );

        $xml = simplexml_load_string( $str );

        $address = \Lukaswhite\Geonames\Mappers\Xml::address( $xml->address[ 0 ] );

        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Address::class, $address );

        $this->assertEquals( 'Roble Ave', $address->getStreet( ) );
        $this->assertEquals( '649', $address->getStreetNumber( ) );
        $this->assertEquals( '94025', $address->getPostalCode( ) );
        $this->assertEquals( 'US', $address->getCountryCode( ) );
        $this->assertEquals( 'CA', $address->getAdminCode1( ) );
        $this->assertEquals( 'California', $address->getAdminName1( ) );
        $this->assertEquals( '081', $address->getAdminCode2( ) );
        $this->assertEquals( 'San Mateo', $address->getAdminName2( ) );
        $this->assertEquals( 0.04, $address->getDistance( ) );
        $this->assertEquals( 37.45127, $address->getLatitude( ) );
        $this->assertEquals( -122.18032, $address->getLongitude( ) );
        $this->assertEquals( 'S1400', $address->getMtfcc( ) );
        $this->assertEquals( 'Menlo Park', $address->getPlaceName( ) );
        $this->assertEquals( 'Menlo Park', $address->getName( ) );

    }

    private function assertUkShort( $uk )
    {
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Feature::class, $uk );

        $this->assertEquals( 2635167, $uk->getId( ) );
        $this->assertEquals( 'United Kingdom', $uk->getName( ) );
        $this->assertEquals( 'United Kingdom of Great Britain and Northern Ireland', $uk->getToponymName( ) );
        $this->assertNotNull( $uk->getCoordinates( ) );
        $this->assertEquals( 54.75844, $uk->getCoordinates( )->getLatitude( ) );
        $this->assertEquals( -2.69531, $uk->getCoordinates( )->getLongitude( ) );
        $this->assertEquals( 'A', $uk->getFcl( ) );
        $this->assertEquals( 'PCLI', $uk->getFcode( ) );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Classification::class, $uk->getClassification( ) );
        $this->assertEquals( 'A', $uk->getClassification( )->getClass( ) );
        $this->assertEquals( 'PCLI', $uk->getClassification( )->getCode( ) );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Country::class, $uk->getCountry( ) );
        $this->assertEquals( 'GB', $uk->getCountry( )->getCode( ) );
    }

}