<?php

use Lukaswhite\Geonames\Query\Hierarchy;

class NeighboursHierarchyTest extends PHPUnit_Framework_TestCase{

    public function testBuildingQuery( )
    {
        $search = ( new Hierarchy\Neighbours( 12345 ) );
        $this->assertEquals( 'neighbours', $search->getUri( ) );
        $this->assertEquals( 'features', $search->expects( ) );
        $this->assertArrayHasKey( 'geonameId', $search->build( ) );
        $this->assertEquals( 12345, $search->build( )[ 'geonameId' ] );
        unset( $search );

        $place = new \Lukaswhite\Geonames\Models\Feature( );
        $place->setId( 12345 );
        $search = ( new Hierarchy\Neighbours( $place ) );
        $this->assertAttributeEquals( 12345, 'geonamesId', $search );
    }

    public function testUsingCountryCodeRatherThanGeonamesId( )
    {
        $search = ( new Hierarchy\Neighbours( 'GB' ) );
        $this->assertArrayNotHasKey( 'geonameId', $search->build( ) );
        $this->assertArrayHasKey( 'country', $search->build( ) );
        $this->assertEquals( 'GB', $search->build( )[ 'country' ] );
        unset( $search );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorThrowsExceptionIfPlaceInvalidType( )
    {
        $search = ( new Hierarchy\Neighbours( true ) );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorThrowsExceptionIfPlaceWrongTypeOfObject( )
    {
        $postcode = new \Lukaswhite\Geonames\Models\PostalCode( );
        $search = ( new Hierarchy\Neighbours( $postcode ) );
    }
}