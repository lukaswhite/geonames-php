<?php

use Lukaswhite\Geonames\Query\CountryInfo;

class CountryInfoQueryTest extends PHPUnit_Framework_TestCase{
	

    public function testIsThereAnySyntaxError( )
    {
        $var = new CountryInfo( );
        $this->assertTrue( is_object( $var ) );
        unset( $var );
    }

    public function testReturnsTheUri( )
    {
        $search = new CountryInfo( );
        $this->assertEquals( 'countryInfo', $search->getUri( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $search = new CountryInfo( );
        $this->assertEquals( 'countries', $search->expects( ) );
    }

    public function testBuild( )
    {
        $search = new CountryInfo( );
        $search->inCountries( [ 'GB', 'ES' ] )->language( 'en' );
        $this->assertEquals( [
            'lang'  =>  'en',
            'country' => [ 'GB', 'ES' ]
        ], $search->build( ) );
    }

    public function testBuildEmpty( )
    {
        $search = new CountryInfo( );
        $this->assertEquals( [ ], $search->build( ) );
    }

}