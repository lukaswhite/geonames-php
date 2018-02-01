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
        $query = new PostalCodeSearch( );
        $this->assertEquals( 'postalCodeSearch', $query->getUri( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $query = new PostalCodeSearch( );
        $this->assertEquals( 'codes', $query->expects( ) );
    }

    public function testSearchOnPostalCode( )
    {
        $query = new PostalCodeSearch( );
        $this->assertEquals( $query, $query->postalCode( 'M1' ) );
        $this->assertArrayHasKey( 'postalcode', $query->build( ) );
        $this->assertEquals( 'M1', $query->build( )[ 'postalcode' ] );
    }

    public function testSearchOnPostalCodeStartsWith( )
    {
        $query = new PostalCodeSearch( );
        $this->assertEquals( $query, $query->postalCodeStartsWith( 'M' ) );
        $this->assertArrayHasKey( 'postalcode_startsWith', $query->build( ) );
        $this->assertEquals( 'M', $query->build( )[ 'postalcode_startsWith' ] );
    }

    public function testSearchOnPlaceName( )
    {
        $query = new PostalCodeSearch( );
        $this->assertEquals( $query, $query->placeName( 'London' ) );
        $this->assertArrayHasKey( 'placename', $query->build( ) );
        $this->assertEquals( 'London', $query->build( )[ 'placename' ] );
    }

    public function testSearchOnPlaceNameStartsWith( )
    {
        $query = new PostalCodeSearch( );
        $this->assertEquals( $query, $query->placeNameStartsWith( 'Lon' ) );
        $this->assertArrayHasKey( 'placename_startsWith', $query->build( ) );
        $this->assertEquals( 'Lon', $query->build( )[ 'placename_startsWith' ] );
    }

    public function testSpecifyingIsReduced( )
    {
        $query = new PostalCodeSearch( );
        $this->assertEquals( $query, $query->reduced( ) );
        $this->assertArrayHasKey( 'isReduced', $query->build( ) );
        $this->assertEquals( true, $query->build( )[ 'isReduced' ] );
        unset( $query );

        $query = new PostalCodeSearch( );
        $this->assertEquals( $query, $query->reduced( false ) );
        $this->assertArrayHasKey( 'isReduced', $query->build( ) );
        $this->assertEquals( false, $query->build( )[ 'isReduced' ] );
        unset( $query );
    }

    public function testIncludingBoundingBox( )
    {
        $query = new PostalCodeSearch( );
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

    public function testBuildEmpty( )
    {
        $query = new PostalCodeSearch( );
        $this->assertEquals( [ ], $query->build( ) );
    }

}