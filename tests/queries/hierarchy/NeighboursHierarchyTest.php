<?php

use Lukaswhite\Geonames\Query\Hierarchy;

class NeighboursHierarchyTest extends PHPUnit_Framework_TestCase{

    public function testBuildingQuery( )
    {
        $query = ( new Hierarchy\Neighbours( 12345 ) );
        $this->assertEquals( 'neighbours', $query->getUri( ) );
        $this->assertEquals( 'features', $query->expects( ) );
        $this->assertArrayHasKey( 'geonameId', $query->build( ) );
        $this->assertEquals( 12345, $query->build( )[ 'geonameId' ] );
        unset( $query );

        $place = new \Lukaswhite\Geonames\Models\Feature( );
        $place->setId( 12345 );
        $query = ( new Hierarchy\Neighbours( $place ) );
        $this->assertAttributeEquals( 12345, 'geonamesId', $query );
    }

    public function testUsingCountryCodeRatherThanGeonamesId( )
    {
        $query = ( new Hierarchy\Neighbours( 'GB' ) );
        $this->assertArrayNotHasKey( 'geonameId', $query->build( ) );
        $this->assertArrayHasKey( 'country', $query->build( ) );
        $this->assertEquals( 'GB', $query->build( )[ 'country' ] );
        unset( $query );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorThrowsExceptionIfPlaceInvalidType( )
    {
        $query = ( new Hierarchy\Neighbours( true ) );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorThrowsExceptionIfPlaceWrongTypeOfObject( )
    {
        $postcode = new \Lukaswhite\Geonames\Models\PostalCode( );
        $query = ( new Hierarchy\Neighbours( $postcode ) );
    }
}