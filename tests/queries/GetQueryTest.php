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
        $search = new Get( );
        $this->assertEquals( 'get', $search->getUri( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $search = new Get( );
        $this->assertEquals( 'feature', $search->expects( ) );
    }

    public function testSettingPlace( )
    {
        $search = new Get( 12345 );
        $this->assertAttributeEquals( 12345, 'geonamesId', $search );
        $this->assertArrayHasKey( 'geonameId', $search->build( ) );
        $this->assertEquals( 12345, $search->build( )[ 'geonameId' ] );
        unset( $search );

        $place = new \Lukaswhite\Geonames\Models\Feature( );
        $place->setId( 12345 );
        $search = new Get( $place );
        $this->assertAttributeEquals( 12345, 'geonamesId', $search );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionIfPlaceInvalid( )
    {
        $search = new Get( );
        $search->setPlace( false );
    }

}