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
        $query = new Search( );
        $this->assertEquals( [ ], $query->build( ) );
    }

    public function testReturnsTheUri( )
    {
        $query = new Search( );
        $this->assertEquals( 'search', $query->getUri( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $query = new Search( );
        $this->assertEquals( 'features', $query->expects( ) );
    }

    public function testOrdering( )
    {
        $query = new Search( );
        $this->assertInstanceOf( Search::class, $query->orderBy( 'population' ) );
        $this->assertAttributeEquals( 'population', 'orderBy', $query );
        $this->assertArrayHasKey( 'orderby', $query->build( ) );
        $this->assertEquals( 'population', $query->build( )[ 'orderby' ] );
        unset( $query );

        $query = new Search( );
        $this->assertInstanceOf( Search::class, $query->orderBy( 'elevation' ) );
        $this->assertAttributeEquals( 'elevation', 'orderBy', $query );
        $this->assertArrayHasKey( 'orderby', $query->build( ) );
        $this->assertEquals( 'elevation', $query->build( )[ 'orderby' ] );
        unset( $query );

        $query = new Search( );
        $this->assertInstanceOf( Search::class, $query->orderBy( 'relevance' ) );
        $this->assertAttributeEquals( 'relevance', 'orderBy', $query );
        $this->assertArrayHasKey( 'orderby', $query->build( ) );
        $this->assertEquals( 'relevance', $query->build( )[ 'orderby' ] );
        unset( $query );

        $query = new Search( );
        $this->assertInstanceOf( Search::class, $query->orderByPopulation() );
        $this->assertAttributeEquals( 'population', 'orderBy', $query );
        $this->assertArrayHasKey( 'orderby', $query->build( ) );
        $this->assertEquals( 'population', $query->build( )[ 'orderby' ] );
        unset( $query );

        $query = new Search( );
        $this->assertInstanceOf( Search::class, $query->orderByElevation() );
        $this->assertAttributeEquals( 'elevation', 'orderBy', $query );
        $this->assertArrayHasKey( 'orderby', $query->build( ) );
        $this->assertEquals( 'elevation', $query->build( )[ 'orderby' ] );
        unset( $query );

        $query = new Search( );
        $this->assertInstanceOf( Search::class, $query->orderByRelevance() );
        $this->assertAttributeEquals( 'relevance', 'orderBy', $query );
        $this->assertArrayHasKey( 'orderby', $query->build( ) );
        $this->assertEquals( 'relevance', $query->build( )[ 'orderby' ] );
        unset( $query );

    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidOrderBy( )
    {
        $query = new Search( );
        $query->orderBy( 'fifa_ranking' );
    }

    public function testCities( )
    {
        $query = new Search();
        $this->assertInstanceOf( Search::class, $query->cities( 'cities1000' ) );
        $this->assertAttributeEquals( 'cities1000', 'cities', $query );
        $this->assertArrayHasKey( 'cities', $query->build() );
        $this->assertEquals( 'cities1000', $query->build()[ 'cities' ] );
        unset( $query );

        $query = new Search();
        $this->assertInstanceOf( Search::class, $query->cities( 'cities5000' ) );
        $this->assertEquals( 'cities5000', $query->build()[ 'cities' ] );
        unset( $query );

        $query = new Search();
        $this->assertInstanceOf( Search::class, $query->cities( 'cities15000' ) );
        $this->assertEquals( 'cities15000', $query->build()[ 'cities' ] );
        unset( $query );

        $query = new Search();
        $this->assertInstanceOf( Search::class, $query->populationOver1000() );
        $this->assertAttributeEquals( 'cities1000', 'cities', $query );
        $this->assertArrayHasKey( 'cities', $query->build() );
        $this->assertEquals( 'cities1000', $query->build()[ 'cities' ] );
        unset( $query );

        $query = new Search();
        $this->assertInstanceOf( Search::class, $query->populationOver5000() );
        $this->assertAttributeEquals( 'cities5000', 'cities', $query );
        $this->assertArrayHasKey( 'cities', $query->build() );
        $this->assertEquals( 'cities5000', $query->build()[ 'cities' ] );
        unset( $query );

        $query = new Search();
        $this->assertInstanceOf( Search::class, $query->populationOver15000() );
        $this->assertAttributeEquals( 'cities15000', 'cities', $query );
        $this->assertArrayHasKey( 'cities', $query->build() );
        $this->assertEquals( 'cities15000', $query->build()[ 'cities' ] );
        unset( $query );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidCities( )
    {
        $query = new Search( );
        $query->cities( 'really_big' );
    }

    public function testQuery( )
    {
        $query = new Search( );
        $this->assertArrayNotHasKey( 'q', $query->build( ) );
        $this->assertInstanceOf( Search::class, $query->query( 'london' ) );
        $this->assertArrayHasKey( 'q', $query->build() );
        $this->assertEquals( 'london', $query->build()[ 'q' ] );
        unset( $query );

        $query = new Search( );
        $query->query( 'New York' );
        $this->assertEquals( 'New+York', $query->build()[ 'q' ] ); // URL encoded
        unset( $query );

        $query = new Search( );
        $query->query( 'Tromsø' );
        //$this->assertEquals( 'Troms%C3%83%C2%B8', $query->build()[ 'q' ] ); // UTF8 encoded
        unset( $query );
    }

    public function testName( )
    {
        $query = new Search( );
        $this->assertArrayNotHasKey( 'name', $query->build( ) );
        $this->assertInstanceOf( Search::class, $query->name( 'london' ) );
        $this->assertArrayHasKey( 'name', $query->build() );
        $this->assertEquals( 'london', $query->build()[ 'name' ] );
        unset( $query );

        $query = new Search( );
        $this->assertArrayNotHasKey( 'name', $query->build( ) );
        $query->name( 'New York' );
        $this->assertArrayHasKey( 'name', $query->build() );
        $this->assertEquals( 'New+York', $query->build()[ 'name' ] ); // URL encoded
        unset( $query );
    }

    public function testNameEquals( )
    {
        $query = new Search();
        $this->assertArrayNotHasKey( 'name_equals', $query->build() );
        $this->assertInstanceOf( Search::class, $query->nameEquals( 'london' ) );
        $this->assertArrayHasKey( 'name_equals', $query->build() );
        $this->assertEquals( 'london', $query->build()[ 'name_equals' ] );
        unset( $query );
    }

    public function testNameStartsWith( )
    {
        $query = new Search();
        $this->assertArrayNotHasKey( 'name_startsWith', $query->build() );
        $this->assertInstanceOf( Search::class, $query->nameStartsWith( 'Lo' ) );
        $this->assertArrayHasKey( 'name_startsWith', $query->build() );
        $this->assertEquals( 'Lo', $query->build()[ 'name_startsWith' ] );
        unset( $query );
    }

    public function testNameIsRequired( )
    {
        $query = new Search( );
        $this->assertArrayNotHasKey( 'isNameRequired', $query->build( ) );
        $this->assertInstanceOf( Search::class, $query->nameIsRequired( ) );
        $this->assertArrayHasKey( 'isNameRequired', $query->build() );
        $this->assertTrue( $query->build()[ 'isNameRequired' ] );
        unset( $query );
        $query = new Search( );
        $query->nameIsRequired( false );
        $this->assertArrayHasKey( 'isNameRequired', $query->build() );
        $this->assertFalse( $query->build()[ 'isNameRequired' ] );
    }

    public function testFuzziness( )
    {
        $query = new Search( );
        $this->assertArrayNotHasKey( 'fuzzy', $query->build( ) );
        $this->assertInstanceOf( Search::class, $query->fuzzy( 0.5 ) );
        $this->assertArrayHasKey( 'fuzzy', $query->build() );
        $this->assertEquals( 0.5, $query->build( )[ 'fuzzy' ] );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFuzzinessTooLow( )
    {
        $query = new Search( );
        $this->assertArrayNotHasKey( 'fuzzy', $query->build( ) );
        $query->fuzzy( -1 );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFuzzinessTooHigh( )
    {
        $query = new Search( );
        $this->assertArrayNotHasKey( 'fuzzy', $query->build( ) );
        $query->fuzzy( 1.2 );
    }

    public function testLimit( )
    {
        $query = new Search( );
        $this->assertArrayNotHasKey( 'maxRows', $query->build( ) );
        $this->assertInstanceOf( Search::class, $query->limit( 500 ) );
        $this->assertArrayHasKey( 'maxRows', $query->build() );
        $this->assertEquals( '500', $query->build()[ 'maxRows' ] );
    }

    public function testSettingStartRow( )
    {
        $query = new Search( );
        $this->assertArrayNotHasKey( 'startRow', $query->build( ) );
        $this->assertInstanceOf( Search::class, $query->startAtRow( 100 ) );
        $this->assertArrayHasKey( 'startRow', $query->build() );
        $this->assertEquals( '100', $query->build()[ 'startRow' ] );
    }

    public function testLimitingByCountry( )
    {
        $query = new Search( );
        $this->assertArrayNotHasKey( 'country', $query->build( ) );
        $this->assertInstanceOf( Search::class, $query->inCountry( 'GB' ) );
        $this->assertArrayHasKey( 'country', $query->build() );
        $this->assertInternalType( 'array', $query->build()[ 'country' ] );
        $this->assertEquals( [ 'GB' ], $query->build()[ 'country' ] );
        unset( $query );

        $query = new Search( );
        $country = new \Lukaswhite\Geonames\Models\Country( 'GB', 'Great Britain' );
        $query->inCountry( $country );
        $this->assertArrayHasKey( 'country', $query->build() );
        $this->assertInternalType( 'array', $query->build()[ 'country' ] );
        $this->assertEquals( [ 'GB' ], $query->build()[ 'country' ] );
    }

    public function testLimitingByCountries( )
    {
        $query = new Search( );
        $this->assertArrayNotHasKey( 'country', $query->build( ) );
        $this->assertInstanceOf( Search::class, $query->inCountries( [ 'GB', 'ES' ] ) );
        $this->assertArrayHasKey( 'country', $query->build() );
        $this->assertInternalType( 'array', $query->build()[ 'country' ] );
        $this->assertEquals( [ 'GB', 'ES' ], $query->build()[ 'country' ] );
        unset( $query );

        $query = new Search( );
        $britain = new \Lukaswhite\Geonames\Models\Country( 'GB', 'Great Britain' );
        $spain = new \Lukaswhite\Geonames\Models\Country( 'ES', 'Spain' );
        $query->inCountries( [ $britain, $spain ] );
        $this->assertArrayHasKey( 'country', $query->build() );
        $this->assertInternalType( 'array', $query->build()[ 'country' ] );
        $this->assertEquals( [ 'GB', 'ES' ], $query->build()[ 'country' ] );
    }

    public function testCountryBias( )
    {
        $query = new Search( );
        $spain = new \Lukaswhite\Geonames\Models\Country( 'ES', 'Spain' );
        $this->assertArrayNotHasKey( 'countryBias', $query->build( ) );
        $this->assertInstanceOf( Search::class, $query->countryBias( $spain ) );
        $this->assertArrayHasKey( 'countryBias', $query->build() );
        $this->assertEquals( $spain->getCode( ), $query->build()[ 'countryBias' ] );
        unset( $query );

        $query = new Search( );
        $this->assertArrayNotHasKey( 'countryBias', $query->build( ) );
        $this->assertInstanceOf( Search::class, $query->countryBias( 'ES' ) );
        $this->assertEquals( 'ES', $query->build()[ 'countryBias' ] );
        unset( $query );
    }

    public function testLimitingByContinent( )
    {
        $query = new Search();
        $this->assertArrayNotHasKey( 'continentCode', $query->build() );
        $this->assertInstanceOf( Search::class, $query->inContinent( Continent::EUROPE ) );
        $this->assertArrayHasKey( 'continentCode', $query->build() );
        $this->assertEquals( Continent::EUROPE, $query->build()[ 'continentCode' ] );
        unset( $query );

        $query = new Search();
        $query->inContinent( 'EU' );
        $this->assertEquals( 'EU', $query->build()[ 'continentCode' ] );
        unset( $query );
    }

    public function testFilteringByAdminCode( )
    {
        $query = new Search();
        $this->assertArrayNotHasKey( 'adminCode1', $query->build() );
        $this->assertInstanceOf( Search::class, $query->inAdmin1Code( 'ENG') ); // England
        $this->assertArrayHasKey( 'adminCode1', $query->build() );
        $this->assertEquals( 'ENG', $query->build()[ 'adminCode1' ] );
        unset( $query );

        $query = new Search();
        $this->assertArrayNotHasKey( 'adminCode2', $query->build() );
        $this->assertInstanceOf( Search::class, $query->inAdmin2Code( 'GLA') ); // Greater London
        $this->assertArrayHasKey( 'adminCode2', $query->build() );
        $this->assertEquals( 'GLA', $query->build()[ 'adminCode2' ] );
        unset( $query );

        $query = new Search();
        $this->assertArrayNotHasKey( 'adminCode3', $query->build() );
        $this->assertInstanceOf( Search::class, $query->inAdmin3Code( 'A2') ); // Barnet
        $this->assertArrayHasKey( 'adminCode3', $query->build() );
        $this->assertEquals( 'A2', $query->build()[ 'adminCode3' ] );
        unset( $query );
    }

    public function testTheInMethod( )
    {
        $query = new Search( );
        $manchester = new \Lukaswhite\Geonames\Models\Feature( );
        $this->assertInstanceOf( Search::class, $query->in( $manchester ) );
        $this->assertArrayNotHasKey( 'adminCode1', $query->build() );
        $this->assertArrayNotHasKey( 'adminCode2', $query->build() );
        $this->assertArrayNotHasKey( 'adminCode3', $query->build() );
        unset( $query );

        $query = new Search( );
        $uk = new \Lukaswhite\Geonames\Models\Feature( );
        $uk->setAdminCode1( '00' );
        $query->in( $uk );
        $this->assertArrayHasKey( 'adminCode1', $query->build( ) );
        $this->assertEquals( '00', $query->build( )[ 'adminCode1' ] );
        $this->assertArrayNotHasKey( 'adminCode2', $query->build() );
        $this->assertArrayNotHasKey( 'adminCode3', $query->build() );
        unset( $query );

        $query = new Search( );
        $greaterLondon = new \Lukaswhite\Geonames\Models\Feature( );
        $greaterLondon->setAdminCode1( '00' );
        $greaterLondon->setAdminCode2( 'GLA' );
        $this->assertEquals( 2, $greaterLondon->getAdminCodeLevel( ) );
        $query->in( $greaterLondon );
        $this->assertArrayHasKey( 'adminCode2', $query->build() );
        $this->assertEquals( 'GLA', $query->build( )[ 'adminCode2' ] );
        $this->assertArrayNotHasKey( 'adminCode3', $query->build() );
        unset( $query );

        $query = new Search( );
        $barnet = new \Lukaswhite\Geonames\Models\Feature( );
        $barnet->setAdminCode1( '00' );
        $barnet->setAdminCode2( 'GLA' );
        $barnet->setAdminCode3( 'A2' );
        $query->in( $barnet );
        $this->assertArrayHasKey( 'adminCode3', $query->build() );
        $this->assertEquals( 'A2', $query->build( )[ 'adminCode3' ] );
        unset( $query );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLimitingByInvalidContinent( )
    {
        $query = new Search();
        $query->inContinent( 'XY' );
    }

    public function testLimitingByFeatureClass( )
    {
        $query = new Search( );
        $this->assertArrayNotHasKey( 'featureClass', $query->build( ) );
        $this->assertInstanceOf( Search::class, $query->filterByFeatureClass( 'A' ) );
        $this->assertArrayHasKey( 'featureClass', $query->build() );
        $this->assertInternalType( 'array', $query->build()[ 'featureClass' ] );
        $this->assertEquals( [ 'A' ], $query->build()[ 'featureClass' ] );
        unset( $query );

        $query = new Search( );
        $this->assertArrayNotHasKey( 'featureClass', $query->build( ) );
        $query->filterByFeatureClass( 'A', 'P' );
        $this->assertArrayHasKey( 'featureClass', $query->build() );
        $this->assertInternalType( 'array', $query->build()[ 'featureClass' ] );
        $this->assertEquals( [ 'A', 'P' ], $query->build()[ 'featureClass' ] );
        unset( $query );
    }

    public function testLimitingByFeatureCode( )
    {
        $query = new Search( );
        $this->assertArrayNotHasKey( 'featureCode', $query->build( ) );
        $query->filterByFeatureCode( 'PPL' );
        $this->assertArrayHasKey( 'featureCode', $query->build() );
        $this->assertInternalType( 'array', $query->build()[ 'featureCode' ] );
        $this->assertEquals( [ 'PPL' ], $query->build()[ 'featureCode' ] );
        unset( $query );

        $query = new Search( );
        $this->assertArrayNotHasKey( 'featureClass', $query->build( ) );
        $query->filterByFeatureCode( 'PPL', 'PPLA2' );
        $this->assertArrayHasKey( 'featureCode', $query->build() );
        $this->assertInternalType( 'array', $query->build()[ 'featureCode' ] );
        $this->assertEquals( [ 'PPL', 'PPLA2' ], $query->build()[ 'featureCode' ] );
        unset( $query );
    }

    public function testJustCountriesStatesRegions( )
    {
        $query = new Search( );
        $query->justCountriesStatesRegions( );
        $this->assertEquals( [ 'A' ], $query->build()[ 'featureClass' ] );
    }

    public function testJustCitiesVillages( )
    {
        $query = new Search( );
        $query->justCitiesVillages( );
        $this->assertEquals( [ 'P' ], $query->build()[ 'featureClass' ] );
    }

    public function testSpecifyingLanguage( )
    {
        $query = new Search( );
        $this->assertArrayNotHasKey( 'lang', $query->build( ) );
        $this->assertInstanceOf( Search::class, $query->language( 'fr' ) );
        $this->assertArrayHasKey( 'lang', $query->build() );
        $this->assertEquals( 'fr', $query->build()[ 'lang' ] );
        unset( $query );
    }

    public function testSpecifyingSearchLanguage( )
    {
        $query = new Search( );
        $this->assertArrayNotHasKey( 'searchlang', $query->build( ) );
        $this->assertInstanceOf( Search::class, $query->searchLanguage( 'de' ) );
        $this->assertArrayHasKey( 'searchlang', $query->build() );
        $this->assertEquals( 'de', $query->build()[ 'searchlang' ] );
        unset( $query );
    }

    public function testStyle( )
    {
        $query = new Search( );
        $this->assertArrayNotHasKey( 'style', $query->build( ) );
        $this->assertInstanceOf( Search::class, $query->style( 'FULL' ) );
        $this->assertArrayHasKey( 'style', $query->build() );
        $this->assertEquals( 'FULL', $query->build()[ 'style' ] );
        unset( $query );

        $query = new Search( );
        $query->style( 'short' );
        $this->assertEquals( 'SHORT', $query->build()[ 'style' ] );
        unset( $query );

        $query = new Search( );
        $query->style( 'MedIUM' );
        $this->assertEquals( 'MEDIUM', $query->build()[ 'style' ] );
        unset( $query );

        $query = new Search( );
        $query->style( 'LONG' );
        $this->assertEquals( 'LONG', $query->build()[ 'style' ] );
        unset( $query );

        $query = new Search( );
        $query->short( );
        $this->assertEquals( 'SHORT', $query->build()[ 'style' ] );
        $query->medium( );
        $this->assertEquals( 'MEDIUM', $query->build()[ 'style' ] );
        $query->long( );
        $this->assertEquals( 'LONG', $query->build()[ 'style' ] );
        $query->full( );
        $this->assertEquals( 'FULL', $query->build()[ 'style' ] );
        unset( $query );

        $query = new Search( );
        $query->verbosity( 'LONG' );
        $this->assertEquals( 'LONG', $query->build()[ 'style' ] );
        unset( $query );
    }

    public function testTag( )
    {
        $query = new Search( );
        $this->assertArrayNotHasKey( 'tag', $query->build( ) );
        $this->assertInstanceOf( Search::class, $query->taggedWith( 'big' ) );
        $this->assertArrayHasKey( 'tag', $query->build() );
        $this->assertEquals( 'big', $query->build()[ 'tag' ] );
        unset( $query );
    }

    public function testOperator( )
    {
        $query = new Search( );
        $this->assertArrayNotHasKey( 'operator', $query->build( ) );
        $this->assertInstanceOf( Search::class, $query->operator( 'AND' ) );
        $this->assertArrayHasKey( 'operator', $query->build() );
        $this->assertEquals( 'AND', $query->build()[ 'operator' ] );
        unset( $query );

        $query = new Search( );
        $query->operator( 'OR' );
        $this->assertEquals( 'OR', $query->build()[ 'operator' ] );
        unset( $query );

        $query = new Search( );
        $this->assertInstanceOf( Search::class, $query->andOperator( ) );
        $this->assertEquals( 'AND', $query->build()[ 'operator' ] );
        unset( $query );

        $query = new Search( );
        $this->assertInstanceOf( Search::class, $query->orOperator( ) );
        $this->assertEquals( 'OR', $query->build()[ 'operator' ] );
        unset( $query );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidOperator( )
    {
        $query = new Search();
        $query->operator( 'either' );
    }

    public function testSpecifyingCharacterSet( )
    {
        $query = new Search( );
        $this->assertArrayNotHasKey( 'charset', $query->build( ) );
        $this->assertInstanceOf( Search::class, $query->characterSet( 'Extended_Latin-8' ) );
        $this->assertArrayHasKey( 'charset', $query->build() );
        $this->assertEquals( 'Extended_Latin-8', $query->build()[ 'charset' ] );
        unset( $query );
    }

    public function testIncludingBoundingBoxInfo( )
    {
        $query = new Search( );
        $this->assertArrayNotHasKey( 'inclBbox', $query->build( ) );
        $this->assertInstanceOf( Search::class, $query->includeBoundingBoxInfo( ) );
        $this->assertArrayHasKey( 'inclBbox', $query->build() );
        $this->assertEquals( true, $query->build()[ 'inclBbox' ] );
        unset( $query );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidStyle( )
    {
        $query = new Search( );
        $query->style( 'give me all you got' );
    }

    public function testIncludingBoundingBox( )
    {
        $query = new Search( );
        $this->assertArrayNotHasKey( 'west', $query->build( ) );
        $this->assertArrayNotHasKey( 'north', $query->build( ) );
        $this->assertArrayNotHasKey( 'east', $query->build( ) );
        $this->assertArrayNotHasKey( 'south', $query->build( ) );
        $query->setBoundingBox( [
            'west' => 1.95727,
            'north' => 52.19634,
            'east' => 1.44968,
            'south' => 50.57491,
        ]);
        $this->assertArrayHasKey( 'west', $query->build( ) );
        $this->assertArrayHasKey( 'north', $query->build( ) );
        $this->assertArrayHasKey( 'east', $query->build( ) );
        $this->assertArrayHasKey( 'south', $query->build( ) );
        $this->assertEquals( 1.95727, $query->build( )[ 'west' ] );
        $this->assertEquals( 52.19634, $query->build( )[ 'north' ] );
        $this->assertEquals( 1.44968, $query->build( )[ 'east' ] );
        $this->assertEquals( 50.57491, $query->build( )[ 'south' ] );

    }

    public function testCombiningFilters( )
    {
        $query = new Search( );

        $query->filterByFeatureClass( 'A', 'P' )
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
            $query->build( )
        );

    }
   
}