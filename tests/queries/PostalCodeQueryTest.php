<?php

use Lukaswhite\Geonames\Query\PostalCodeSearch;

class PostalCodeQueryTest extends PHPUnit_Framework_TestCase{


    public function testIsThereAnySyntaxError( )
    {
        $var = new PostalCodeSearch( );
        $this->assertTrue( is_object( $var ) );
        unset( $var );
    }

    public function testReturnsTheUri( )
    {
        $search = new PostalCodeSearch( );
        $this->assertEquals( 'postalCodeSearch', $search->getUri( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $search = new PostalCodeSearch( );
        $this->assertEquals( 'codes', $search->expects( ) );
    }

    public function testSearchOnPostalCode( )
    {
        $search = new PostalCodeSearch( );
        $this->assertEquals( $search, $search->postalCode( 'M1' ) );
        $this->assertArrayHasKey( 'postalcode', $search->build( ) );
        $this->assertEquals( 'M1', $search->build( )[ 'postalcode' ] );
    }

    public function testSearchOnPostalCodeStartsWith( )
    {
        $search = new PostalCodeSearch( );
        $this->assertEquals( $search, $search->postalCodeStartsWith( 'M' ) );
        $this->assertArrayHasKey( 'postalcode_startsWith', $search->build( ) );
        $this->assertEquals( 'M', $search->build( )[ 'postalcode_startsWith' ] );
    }

    public function testSearchOnPlaceName( )
    {
        $search = new PostalCodeSearch( );
        $this->assertEquals( $search, $search->placeName( 'London' ) );
        $this->assertArrayHasKey( 'placename', $search->build( ) );
        $this->assertEquals( 'London', $search->build( )[ 'placename' ] );
    }

    public function testSearchOnPlaceNameStartsWith( )
    {
        $search = new PostalCodeSearch( );
        $this->assertEquals( $search, $search->placeNameStartsWith( 'Lon' ) );
        $this->assertArrayHasKey( 'placename_startsWith', $search->build( ) );
        $this->assertEquals( 'Lon', $search->build( )[ 'placename_startsWith' ] );
    }

    public function testSpecifyingIsReduced( )
    {
        $search = new PostalCodeSearch( );
        $this->assertEquals( $search, $search->reduced( ) );
        $this->assertArrayHasKey( 'isReduced', $search->build( ) );
        $this->assertEquals( true, $search->build( )[ 'isReduced' ] );
        unset( $search );

        $search = new PostalCodeSearch( );
        $this->assertEquals( $search, $search->reduced( false ) );
        $this->assertArrayHasKey( 'isReduced', $search->build( ) );
        $this->assertEquals( false, $search->build( )[ 'isReduced' ] );
        unset( $search );
    }

    public function testIncludingBoundingBox( )
    {
        $search = new PostalCodeSearch( );
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

    public function testBuildEmpty( )
    {
        $search = new PostalCodeSearch( );
        $this->assertEquals( [ ], $search->build( ) );
    }

}