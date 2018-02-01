<?php

use Lukaswhite\Geonames\Query\Hierarchy;

class HierarchyHierarchyTest extends PHPUnit_Framework_TestCase{

    public function testBuildingQuery( )
    {
        $query = ( new Hierarchy\Hierarchy( 12345 ) );
        $this->assertAttributeEquals( 12345, 'geonamesId', $query );
        $this->assertEquals( 'hierarchy', $query->getUri( ) );
        $this->assertEquals( 'features', $query->expects( ) );
        $this->assertArrayHasKey( 'geonameId', $query->build( ) );
        $this->assertEquals( 12345, $query->build( )[ 'geonameId' ] );

        $place = new \Lukaswhite\Geonames\Models\Feature( );
        $place->setId( 12345 );
        $query = ( new Hierarchy\Hierarchy( $place ) );
        $this->assertAttributeEquals( 12345, 'geonamesId', $query );
    }

}