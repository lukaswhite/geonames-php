<?php

use Lukaswhite\Geonames\Query\Search;
use Lukaswhite\Geonames\Models\Continent;
use Lukaswhite\Geonames\Models\Geoname;

class SearchQueryTest extends PHPUnit_Framework_TestCase{
	

    public function testIsThereAnySyntaxError( )
    {
        $var = new Search( );
        $this->assertTrue( is_object( $var ) );
        unset( $var );
    }

    public function testBuildQueryWithDefaults( )
    {
        $search = new Search( );
        $this->assertEquals( [ ], $search->build( ) );
    }

    public function testReturnsTheUri( )
    {
        $search = new Search( );
        $this->assertEquals( 'search', $search->getUri( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $search = new Search( );
        $this->assertEquals( 'features', $search->expects( ) );
    }

    public function testOrdering( )
    {
        $search = new Search( );
        $this->assertInstanceOf( Search::class, $search->orderBy( 'population' ) );
        $this->assertAttributeEquals( 'population', 'orderBy', $search );
        $this->assertArrayHasKey( 'orderby', $search->build( ) );
        $this->assertEquals( 'population', $search->build( )[ 'orderby' ] );
        unset( $search );

        $search = new Search( );
        $this->assertInstanceOf( Search::class, $search->orderBy( 'elevation' ) );
        $this->assertAttributeEquals( 'elevation', 'orderBy', $search );
        $this->assertArrayHasKey( 'orderby', $search->build( ) );
        $this->assertEquals( 'elevation', $search->build( )[ 'orderby' ] );
        unset( $search );

        $search = new Search( );
        $this->assertInstanceOf( Search::class, $search->orderBy( 'relevance' ) );
        $this->assertAttributeEquals( 'relevance', 'orderBy', $search );
        $this->assertArrayHasKey( 'orderby', $search->build( ) );
        $this->assertEquals( 'relevance', $search->build( )[ 'orderby' ] );
        unset( $search );

        $search = new Search( );
        $this->assertInstanceOf( Search::class, $search->orderByPopulation() );
        $this->assertAttributeEquals( 'population', 'orderBy', $search );
        $this->assertArrayHasKey( 'orderby', $search->build( ) );
        $this->assertEquals( 'population', $search->build( )[ 'orderby' ] );
        unset( $search );

        $search = new Search( );
        $this->assertInstanceOf( Search::class, $search->orderByElevation() );
        $this->assertAttributeEquals( 'elevation', 'orderBy', $search );
        $this->assertArrayHasKey( 'orderby', $search->build( ) );
        $this->assertEquals( 'elevation', $search->build( )[ 'orderby' ] );
        unset( $search );

        $search = new Search( );
        $this->assertInstanceOf( Search::class, $search->orderByRelevance() );
        $this->assertAttributeEquals( 'relevance', 'orderBy', $search );
        $this->assertArrayHasKey( 'orderby', $search->build( ) );
        $this->assertEquals( 'relevance', $search->build( )[ 'orderby' ] );
        unset( $search );

    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidOrderBy( )
    {
        $search = new Search( );
        $search->orderBy( 'fifa_ranking' );
    }

    public function testCities( )
    {
        $search = new Search();
        $this->assertInstanceOf( Search::class, $search->cities( 'cities1000' ) );
        $this->assertAttributeEquals( 'cities1000', 'cities', $search );
        $this->assertArrayHasKey( 'cities', $search->build() );
        $this->assertEquals( 'cities1000', $search->build()[ 'cities' ] );
        unset( $search );

        $search = new Search();
        $this->assertInstanceOf( Search::class, $search->cities( 'cities5000' ) );
        $this->assertEquals( 'cities5000', $search->build()[ 'cities' ] );
        unset( $search );

        $search = new Search();
        $this->assertInstanceOf( Search::class, $search->cities( 'cities15000' ) );
        $this->assertEquals( 'cities15000', $search->build()[ 'cities' ] );
        unset( $search );

        $search = new Search();
        $this->assertInstanceOf( Search::class, $search->populationOver1000() );
        $this->assertAttributeEquals( 'cities1000', 'cities', $search );
        $this->assertArrayHasKey( 'cities', $search->build() );
        $this->assertEquals( 'cities1000', $search->build()[ 'cities' ] );
        unset( $search );

        $search = new Search();
        $this->assertInstanceOf( Search::class, $search->populationOver5000() );
        $this->assertAttributeEquals( 'cities5000', 'cities', $search );
        $this->assertArrayHasKey( 'cities', $search->build() );
        $this->assertEquals( 'cities5000', $search->build()[ 'cities' ] );
        unset( $search );

        $search = new Search();
        $this->assertInstanceOf( Search::class, $search->populationOver15000() );
        $this->assertAttributeEquals( 'cities15000', 'cities', $search );
        $this->assertArrayHasKey( 'cities', $search->build() );
        $this->assertEquals( 'cities15000', $search->build()[ 'cities' ] );
        unset( $search );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidCities( )
    {
        $search = new Search( );
        $search->cities( 'really_big' );
    }

    public function testQuery( )
    {
        $search = new Search( );
        $this->assertArrayNotHasKey( 'q', $search->build( ) );
        $this->assertInstanceOf( Search::class, $search->query( 'london' ) );
        $this->assertArrayHasKey( 'q', $search->build() );
        $this->assertEquals( 'london', $search->build()[ 'q' ] );
        unset( $search );

        $search = new Search( );
        $search->query( 'New York' );
        $this->assertEquals( 'New+York', $search->build()[ 'q' ] ); // URL encoded
        unset( $search );

        $search = new Search( );
        $search->query( 'Tromsø' );
        //$this->assertEquals( 'Troms%C3%83%C2%B8', $search->build()[ 'q' ] ); // UTF8 encoded
        unset( $search );
    }

    public function testName( )
    {
        $search = new Search( );
        $this->assertArrayNotHasKey( 'name', $search->build( ) );
        $this->assertInstanceOf( Search::class, $search->name( 'london' ) );
        $this->assertArrayHasKey( 'name', $search->build() );
        $this->assertEquals( 'london', $search->build()[ 'name' ] );
        unset( $search );

        $search = new Search( );
        $this->assertArrayNotHasKey( 'name', $search->build( ) );
        $search->name( 'New York' );
        $this->assertArrayHasKey( 'name', $search->build() );
        $this->assertEquals( 'New+York', $search->build()[ 'name' ] ); // URL encoded
        unset( $search );
    }

    public function testNameEquals( )
    {
        $search = new Search();
        $this->assertArrayNotHasKey( 'name_equals', $search->build() );
        $this->assertInstanceOf( Search::class, $search->nameEquals( 'london' ) );
        $this->assertArrayHasKey( 'name_equals', $search->build() );
        $this->assertEquals( 'london', $search->build()[ 'name_equals' ] );
        unset( $search );
    }

    public function testNameStartsWith( )
    {
        $search = new Search();
        $this->assertArrayNotHasKey( 'name_startsWith', $search->build() );
        $this->assertInstanceOf( Search::class, $search->nameStartsWith( 'Lo' ) );
        $this->assertArrayHasKey( 'name_startsWith', $search->build() );
        $this->assertEquals( 'Lo', $search->build()[ 'name_startsWith' ] );
        unset( $search );
    }

    public function testNameIsRequired( )
    {
        $search = new Search( );
        $this->assertArrayNotHasKey( 'isNameRequired', $search->build( ) );
        $this->assertInstanceOf( Search::class, $search->nameIsRequired( ) );
        $this->assertArrayHasKey( 'isNameRequired', $search->build() );
        $this->assertTrue( $search->build()[ 'isNameRequired' ] );
        unset( $search );
        $search = new Search( );
        $search->nameIsRequired( false );
        $this->assertArrayHasKey( 'isNameRequired', $search->build() );
        $this->assertFalse( $search->build()[ 'isNameRequired' ] );
    }

    public function testFuzziness( )
    {
        $search = new Search( );
        $this->assertArrayNotHasKey( 'fuzzy', $search->build( ) );
        $this->assertInstanceOf( Search::class, $search->fuzzy( 0.5 ) );
        $this->assertArrayHasKey( 'fuzzy', $search->build() );
        $this->assertEquals( 0.5, $search->build( )[ 'fuzzy' ] );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFuzzinessTooLow( )
    {
        $search = new Search( );
        $this->assertArrayNotHasKey( 'fuzzy', $search->build( ) );
        $search->fuzzy( -1 );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFuzzinessTooHigh( )
    {
        $search = new Search( );
        $this->assertArrayNotHasKey( 'fuzzy', $search->build( ) );
        $search->fuzzy( 1.2 );
    }

    public function testLimit( )
    {
        $search = new Search( );
        $this->assertArrayNotHasKey( 'maxRows', $search->build( ) );
        $this->assertInstanceOf( Search::class, $search->limit( 500 ) );
        $this->assertArrayHasKey( 'maxRows', $search->build() );
        $this->assertEquals( '500', $search->build()[ 'maxRows' ] );
    }

    public function testSettingStartRow( )
    {
        $search = new Search( );
        $this->assertArrayNotHasKey( 'startRow', $search->build( ) );
        $this->assertInstanceOf( Search::class, $search->startAtRow( 100 ) );
        $this->assertArrayHasKey( 'startRow', $search->build() );
        $this->assertEquals( '100', $search->build()[ 'startRow' ] );
    }

    public function testLimitingByCountry( )
    {
        $search = new Search( );
        $this->assertArrayNotHasKey( 'country', $search->build( ) );
        $this->assertInstanceOf( Search::class, $search->inCountry( 'GB' ) );
        $this->assertArrayHasKey( 'country', $search->build() );
        $this->assertInternalType( 'array', $search->build()[ 'country' ] );
        $this->assertEquals( [ 'GB' ], $search->build()[ 'country' ] );
        unset( $search );

        $search = new Search( );
        $country = new \Lukaswhite\Geonames\Models\Country( 'GB', 'Great Britain' );
        $search->inCountry( $country );
        $this->assertArrayHasKey( 'country', $search->build() );
        $this->assertInternalType( 'array', $search->build()[ 'country' ] );
        $this->assertEquals( [ 'GB' ], $search->build()[ 'country' ] );
    }

    public function testLimitingByCountries( )
    {
        $search = new Search( );
        $this->assertArrayNotHasKey( 'country', $search->build( ) );
        $this->assertInstanceOf( Search::class, $search->inCountries( [ 'GB', 'ES' ] ) );
        $this->assertArrayHasKey( 'country', $search->build() );
        $this->assertInternalType( 'array', $search->build()[ 'country' ] );
        $this->assertEquals( [ 'GB', 'ES' ], $search->build()[ 'country' ] );
        unset( $search );

        $search = new Search( );
        $britain = new \Lukaswhite\Geonames\Models\Country( 'GB', 'Great Britain' );
        $spain = new \Lukaswhite\Geonames\Models\Country( 'ES', 'Spain' );
        $search->inCountries( [ $britain, $spain ] );
        $this->assertArrayHasKey( 'country', $search->build() );
        $this->assertInternalType( 'array', $search->build()[ 'country' ] );
        $this->assertEquals( [ 'GB', 'ES' ], $search->build()[ 'country' ] );
    }

    public function testCountryBias( )
    {
        $search = new Search( );
        $spain = new \Lukaswhite\Geonames\Models\Country( 'ES', 'Spain' );
        $this->assertArrayNotHasKey( 'countryBias', $search->build( ) );
        $this->assertInstanceOf( Search::class, $search->countryBias( $spain ) );
        $this->assertArrayHasKey( 'countryBias', $search->build() );
        $this->assertEquals( $spain->getCode( ), $search->build()[ 'countryBias' ] );
        unset( $search );

        $search = new Search( );
        $this->assertArrayNotHasKey( 'countryBias', $search->build( ) );
        $this->assertInstanceOf( Search::class, $search->countryBias( 'ES' ) );
        $this->assertEquals( 'ES', $search->build()[ 'countryBias' ] );
        unset( $search );
    }

    public function testLimitingByContinent( )
    {
        $search = new Search();
        $this->assertArrayNotHasKey( 'continentCode', $search->build() );
        $this->assertInstanceOf( Search::class, $search->inContinent( Continent::EUROPE ) );
        $this->assertArrayHasKey( 'continentCode', $search->build() );
        $this->assertEquals( Continent::EUROPE, $search->build()[ 'continentCode' ] );
        unset( $search );

        $search = new Search();
        $search->inContinent( 'EU' );
        $this->assertEquals( 'EU', $search->build()[ 'continentCode' ] );
        unset( $search );
    }

    public function testFilteringByAdminCode( )
    {
        $search = new Search();
        $this->assertArrayNotHasKey( 'adminCode1', $search->build() );
        $this->assertInstanceOf( Search::class, $search->inAdmin1Code( 'ENG') ); // England
        $this->assertArrayHasKey( 'adminCode1', $search->build() );
        $this->assertEquals( 'ENG', $search->build()[ 'adminCode1' ] );
        unset( $search );

        $search = new Search();
        $this->assertArrayNotHasKey( 'adminCode2', $search->build() );
        $this->assertInstanceOf( Search::class, $search->inAdmin2Code( 'GLA') ); // Greater London
        $this->assertArrayHasKey( 'adminCode2', $search->build() );
        $this->assertEquals( 'GLA', $search->build()[ 'adminCode2' ] );
        unset( $search );

        $search = new Search();
        $this->assertArrayNotHasKey( 'adminCode3', $search->build() );
        $this->assertInstanceOf( Search::class, $search->inAdmin3Code( 'A2') ); // Barnet
        $this->assertArrayHasKey( 'adminCode3', $search->build() );
        $this->assertEquals( 'A2', $search->build()[ 'adminCode3' ] );
        unset( $search );
    }

    public function testTheInMethod( )
    {
        $search = new Search( );
        $manchester = new \Lukaswhite\Geonames\Models\Feature( );
        $this->assertInstanceOf( Search::class, $search->in( $manchester ) );
        $this->assertArrayNotHasKey( 'adminCode1', $search->build() );
        $this->assertArrayNotHasKey( 'adminCode2', $search->build() );
        $this->assertArrayNotHasKey( 'adminCode3', $search->build() );
        unset( $search );

        $search = new Search( );
        $uk = new \Lukaswhite\Geonames\Models\Feature( );
        $uk->setAdminCode1( '00' );
        $search->in( $uk );
        $this->assertArrayHasKey( 'adminCode1', $search->build( ) );
        $this->assertEquals( '00', $search->build( )[ 'adminCode1' ] );
        $this->assertArrayNotHasKey( 'adminCode2', $search->build() );
        $this->assertArrayNotHasKey( 'adminCode3', $search->build() );
        unset( $search );

        $search = new Search( );
        $greaterLondon = new \Lukaswhite\Geonames\Models\Feature( );
        $greaterLondon->setAdminCode1( '00' );
        $greaterLondon->setAdminCode2( 'GLA' );
        $this->assertEquals( 2, $greaterLondon->getAdminCodeLevel( ) );
        $search->in( $greaterLondon );
        $this->assertArrayHasKey( 'adminCode2', $search->build() );
        $this->assertEquals( 'GLA', $search->build( )[ 'adminCode2' ] );
        $this->assertArrayNotHasKey( 'adminCode3', $search->build() );
        unset( $search );

        $search = new Search( );
        $barnet = new \Lukaswhite\Geonames\Models\Feature( );
        $barnet->setAdminCode1( '00' );
        $barnet->setAdminCode2( 'GLA' );
        $barnet->setAdminCode3( 'A2' );
        $search->in( $barnet );
        $this->assertArrayHasKey( 'adminCode3', $search->build() );
        $this->assertEquals( 'A2', $search->build( )[ 'adminCode3' ] );
        unset( $search );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLimitingByInvalidContinent( )
    {
        $search = new Search();
        $search->inContinent( 'XY' );
    }

    public function testLimitingByFeatureClass( )
    {
        $search = new Search( );
        $this->assertArrayNotHasKey( 'featureClass', $search->build( ) );
        $this->assertInstanceOf( Search::class, $search->filterByFeatureClass( 'A' ) );
        $this->assertArrayHasKey( 'featureClass', $search->build() );
        $this->assertInternalType( 'array', $search->build()[ 'featureClass' ] );
        $this->assertEquals( [ 'A' ], $search->build()[ 'featureClass' ] );
        unset( $search );

        $search = new Search( );
        $this->assertArrayNotHasKey( 'featureClass', $search->build( ) );
        $search->filterByFeatureClass( 'A', 'P' );
        $this->assertArrayHasKey( 'featureClass', $search->build() );
        $this->assertInternalType( 'array', $search->build()[ 'featureClass' ] );
        $this->assertEquals( [ 'A', 'P' ], $search->build()[ 'featureClass' ] );
        unset( $search );
    }

    public function testLimitingByFeatureCode( )
    {
        $search = new Search( );
        $this->assertArrayNotHasKey( 'featureCode', $search->build( ) );
        $search->filterByFeatureCode( 'PPL' );
        $this->assertArrayHasKey( 'featureCode', $search->build() );
        $this->assertInternalType( 'array', $search->build()[ 'featureCode' ] );
        $this->assertEquals( [ 'PPL' ], $search->build()[ 'featureCode' ] );
        unset( $search );

        $search = new Search( );
        $this->assertArrayNotHasKey( 'featureClass', $search->build( ) );
        $search->filterByFeatureCode( 'PPL', 'PPLA2' );
        $this->assertArrayHasKey( 'featureCode', $search->build() );
        $this->assertInternalType( 'array', $search->build()[ 'featureCode' ] );
        $this->assertEquals( [ 'PPL', 'PPLA2' ], $search->build()[ 'featureCode' ] );
        unset( $search );
    }

    public function testJustCountriesStatesRegions( )
    {
        $search = new Search( );
        $search->justCountriesStatesRegions( );
        $this->assertEquals( [ 'A' ], $search->build()[ 'featureClass' ] );
    }

    public function testJustCitiesVillages( )
    {
        $search = new Search( );
        $search->justCitiesVillages( );
        $this->assertEquals( [ 'P' ], $search->build()[ 'featureClass' ] );
    }

    public function testSpecifyingLanguage( )
    {
        $search = new Search( );
        $this->assertArrayNotHasKey( 'lang', $search->build( ) );
        $this->assertInstanceOf( Search::class, $search->language( 'fr' ) );
        $this->assertArrayHasKey( 'lang', $search->build() );
        $this->assertEquals( 'fr', $search->build()[ 'lang' ] );
        unset( $search );
    }

    public function testSpecifyingSearchLanguage( )
    {
        $search = new Search( );
        $this->assertArrayNotHasKey( 'searchlang', $search->build( ) );
        $this->assertInstanceOf( Search::class, $search->searchLanguage( 'de' ) );
        $this->assertArrayHasKey( 'searchlang', $search->build() );
        $this->assertEquals( 'de', $search->build()[ 'searchlang' ] );
        unset( $search );
    }

    public function testStyle( )
    {
        $search = new Search( );
        $this->assertArrayNotHasKey( 'style', $search->build( ) );
        $this->assertInstanceOf( Search::class, $search->style( 'FULL' ) );
        $this->assertArrayHasKey( 'style', $search->build() );
        $this->assertEquals( 'FULL', $search->build()[ 'style' ] );
        unset( $search );

        $search = new Search( );
        $search->style( 'short' );
        $this->assertEquals( 'SHORT', $search->build()[ 'style' ] );
        unset( $search );

        $search = new Search( );
        $search->style( 'MedIUM' );
        $this->assertEquals( 'MEDIUM', $search->build()[ 'style' ] );
        unset( $search );

        $search = new Search( );
        $search->style( 'LONG' );
        $this->assertEquals( 'LONG', $search->build()[ 'style' ] );
        unset( $search );

        $search = new Search( );
        $search->short( );
        $this->assertEquals( 'SHORT', $search->build()[ 'style' ] );
        $search->medium( );
        $this->assertEquals( 'MEDIUM', $search->build()[ 'style' ] );
        $search->long( );
        $this->assertEquals( 'LONG', $search->build()[ 'style' ] );
        $search->full( );
        $this->assertEquals( 'FULL', $search->build()[ 'style' ] );
        unset( $search );

        $search = new Search( );
        $search->verbosity( 'LONG' );
        $this->assertEquals( 'LONG', $search->build()[ 'style' ] );
        unset( $search );
    }

    public function testTag( )
    {
        $search = new Search( );
        $this->assertArrayNotHasKey( 'tag', $search->build( ) );
        $this->assertInstanceOf( Search::class, $search->taggedWith( 'big' ) );
        $this->assertArrayHasKey( 'tag', $search->build() );
        $this->assertEquals( 'big', $search->build()[ 'tag' ] );
        unset( $search );
    }

    public function testOperator( )
    {
        $search = new Search( );
        $this->assertArrayNotHasKey( 'operator', $search->build( ) );
        $this->assertInstanceOf( Search::class, $search->operator( 'AND' ) );
        $this->assertArrayHasKey( 'operator', $search->build() );
        $this->assertEquals( 'AND', $search->build()[ 'operator' ] );
        unset( $search );

        $search = new Search( );
        $search->operator( 'OR' );
        $this->assertEquals( 'OR', $search->build()[ 'operator' ] );
        unset( $search );

        $search = new Search( );
        $this->assertInstanceOf( Search::class, $search->andOperator( ) );
        $this->assertEquals( 'AND', $search->build()[ 'operator' ] );
        unset( $search );

        $search = new Search( );
        $this->assertInstanceOf( Search::class, $search->orOperator( ) );
        $this->assertEquals( 'OR', $search->build()[ 'operator' ] );
        unset( $search );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidOperator( )
    {
        $search = new Search();
        $search->operator( 'either' );
    }

    public function testSpecifyingCharacterSet( )
    {
        $search = new Search( );
        $this->assertArrayNotHasKey( 'charset', $search->build( ) );
        $this->assertInstanceOf( Search::class, $search->characterSet( 'Extended_Latin-8' ) );
        $this->assertArrayHasKey( 'charset', $search->build() );
        $this->assertEquals( 'Extended_Latin-8', $search->build()[ 'charset' ] );
        unset( $search );
    }

    public function testIncludingBoundingBoxInfo( )
    {
        $search = new Search( );
        $this->assertArrayNotHasKey( 'inclBbox', $search->build( ) );
        $this->assertInstanceOf( Search::class, $search->includeBoundingBoxInfo( ) );
        $this->assertArrayHasKey( 'inclBbox', $search->build() );
        $this->assertEquals( true, $search->build()[ 'inclBbox' ] );
        unset( $search );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidStyle( )
    {
        $search = new Search( );
        $search->style( 'give me all you got' );
    }

    public function testIncludingBoundingBox( )
    {
        $search = new Search( );
        $this->assertArrayNotHasKey( 'west', $search->build( ) );
        $this->assertArrayNotHasKey( 'north', $search->build( ) );
        $this->assertArrayNotHasKey( 'east', $search->build( ) );
        $this->assertArrayNotHasKey( 'south', $search->build( ) );
        $search->setBoundingBox( [
            'west' => 1.95727,
            'north' => 52.19634,
            'east' => 1.44968,
            'south' => 50.57491,
        ]);
        $this->assertArrayHasKey( 'west', $search->build( ) );
        $this->assertArrayHasKey( 'north', $search->build( ) );
        $this->assertArrayHasKey( 'east', $search->build( ) );
        $this->assertArrayHasKey( 'south', $search->build( ) );
        $this->assertEquals( 1.95727, $search->build( )[ 'west' ] );
        $this->assertEquals( 52.19634, $search->build( )[ 'north' ] );
        $this->assertEquals( 1.44968, $search->build( )[ 'east' ] );
        $this->assertEquals( 50.57491, $search->build( )[ 'south' ] );

    }

    public function testCombiningFilters( )
    {
        $search = new Search( );

        $search->filterByFeatureClass( 'A', 'P' )
            ->filterByFeatureCode( 'ADM1', 'ADM2' )
            ->inCountry( 'GB' )
            ->limit( 500 );

        $this->assertEquals(
            [
                'featureClass' => [ 'A', 'P' ],
                'featureCode' => [ 'ADM1', 'ADM2' ],
                'country' => [ 'GB' ],
                'maxRows' => 500
            ],
            $search->build( )
        );

    }
   
}