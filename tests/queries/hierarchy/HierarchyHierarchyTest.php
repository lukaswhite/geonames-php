<?php

use Lukaswhite\Geonames\Query\Hierarchy;

class HierarchyHierarchyTest extends PHPUnit_Framework_TestCase{

    public function testBuildingQuery( )
    {
        $search = ( new Hierarchy\Hierarchy( 12345 ) );
        $this->assertAttributeEquals( 12345, 'geonamesId', $search );
        $this->assertEquals( 'hierarchy', $search->getUri( ) );
        $this->assertEquals( 'features', $search->expects( ) );
        $this->assertArrayHasKey( 'geonameId', $search->build( ) );
        $this->assertEquals( 12345, $search->build( )[ 'geonameId' ] );

        $place = new \Lukaswhite\Geonames\Models\Feature( );
        $place->setId( 12345 );
        $search = ( new Hierarchy\Hierarchy( $place ) );
        $this->assertAttributeEquals( 12345, 'geonamesId', $search );
    }

}