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
        $query = new CountryInfo( );
        $this->assertEquals( 'countryInfo', $query->getUri( ) );
    }

    public function testDeclaresWhatItExpects( )
    {
        $query = new CountryInfo( );
        $this->assertEquals( 'countries', $query->expects( ) );
    }

    public function testBuild( )
    {
        $query = new CountryInfo( );
        $query->inCountries( [ 'GB', 'ES' ] )->language( 'en' );
        $this->assertEquals( [
            'lang'  =>  'en',
            'country' => [ 'GB', 'ES' ]
        ], $query->build( ) );
    }

    public function testBuildEmpty( )
    {
        $query = new CountryInfo( );
        $this->assertEquals( [ ], $query->build( ) );
    }

}