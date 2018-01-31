<?php

use Lukaswhite\Geonames\Query\Hierarchy;

class ChildrenHierarchyTest extends PHPUnit_Framework_TestCase{

    public function testBuildingQuery( )
    {
        $search = ( new Hierarchy\Children( 12345 ) );
        $this->assertAttributeEquals( 12345, 'geonamesId', $search );
        $this->assertEquals( 'children', $search->getUri( ) );
        $this->assertEquals( 'features', $search->expects( ) );
        $this->assertArrayHasKey( 'geonameId', $search->build( ) );
        $this->assertEquals( 12345, $search->build( )[ 'geonameId' ] );
        unset( $search );

        $place = new \Lukaswhite\Geonames\Models\Feature( );
        $place->setId( 12345 );
        $search = ( new Hierarchy\Children( $place ) );
        $this->assertAttributeEquals( 12345, 'geonamesId', $search );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionIfPlaceInvalidType( )
    {
        $search = ( new Hierarchy\Children( true ) );
    }

    public function testSettingHierarchy( )
    {
        $search = ( new Hierarchy\Children( 12345 ) );
        $search->ofType( 'tourism' );
        $this->assertArrayHasKey( 'hierarchy', $search->build() );
        $this->assertEquals( 'tourism', $search->build()[ 'hierarchy' ] );
    }

    public function testLimitingQuery( )
    {
        $search = ( new Hierarchy\Children( 12345 ) );
        $search->limit( 250 );
        $this->assertArrayHasKey( 'maxRows', $search->build() );
        $this->assertEquals( 250, $search->build()[ 'maxRows' ] );
    }


}