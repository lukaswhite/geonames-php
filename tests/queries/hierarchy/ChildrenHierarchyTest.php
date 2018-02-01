<?php

use Lukaswhite\Geonames\Query\Hierarchy;

class ChildrenHierarchyTest extends PHPUnit_Framework_TestCase{

    public function testBuildingQuery( )
    {
        $query = ( new Hierarchy\Children( 12345 ) );
        $this->assertAttributeEquals( 12345, 'geonamesId', $query );
        $this->assertEquals( 'children', $query->getUri( ) );
        $this->assertEquals( 'features', $query->expects( ) );
        $this->assertArrayHasKey( 'geonameId', $query->build( ) );
        $this->assertEquals( 12345, $query->build( )[ 'geonameId' ] );
        unset( $query );

        $place = new \Lukaswhite\Geonames\Models\Feature( );
        $place->setId( 12345 );
        $query = ( new Hierarchy\Children( $place ) );
        $this->assertAttributeEquals( 12345, 'geonamesId', $query );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionIfPlaceInvalidType( )
    {
        $query = ( new Hierarchy\Children( true ) );
    }

    public function testSettingHierarchy( )
    {
        $query = ( new Hierarchy\Children( 12345 ) );
        $query->ofType( 'tourism' );
        $this->assertArrayHasKey( 'hierarchy', $query->build() );
        $this->assertEquals( 'tourism', $query->build()[ 'hierarchy' ] );
    }

    public function testLimitingQuery( )
    {
        $query = ( new Hierarchy\Children( 12345 ) );
        $query->limit( 250 );
        $this->assertArrayHasKey( 'maxRows', $query->build() );
        $this->assertEquals( 250, $query->build()[ 'maxRows' ] );
    }


}