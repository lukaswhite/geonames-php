<?php

use Lukaswhite\Geonames\Query\Get;

class GetQueryTest extends PHPUnit_Framework_TestCase{
	

    public function testIsThereAnySyntaxError( )
    {
        $var = new Get( );
        $this->assertTrue( is_object( $var ) );
        unset( $var );
    }

    public function testReturnsTheUri( )
    {
        $query = new Get( );
        $this->assertEquals( 'get', $query->getUri( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $query = new Get( );
        $this->assertEquals( 'feature', $query->expects( ) );
    }

    public function testSettingPlace( )
    {
        $query = new Get( 12345 );
        $this->assertAttributeEquals( 12345, 'geonamesId', $query );
        $this->assertArrayHasKey( 'geonameId', $query->build( ) );
        $this->assertEquals( 12345, $query->build( )[ 'geonameId' ] );
        unset( $query );

        $place = new \Lukaswhite\Geonames\Models\Feature( );
        $place->setId( 12345 );
        $query = new Get( $place );
        $this->assertAttributeEquals( 12345, 'geonamesId', $query );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionIfPlaceInvalid( )
    {
        $query = new Get( );
        $query->setPlace( false );
    }

}