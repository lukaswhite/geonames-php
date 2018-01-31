<?php

use Lukaswhite\Geonames\Models\Address;

class CountrySubdivisionTest extends PHPUnit_Framework_TestCase{

    public function testConstructor( )
    {
        $countrySubdivision = new \Lukaswhite\Geonames\Models\CountrySubdivision( );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\CountrySubdivision::class, $countrySubdivision );
        $this->assertInstanceOf( \Lukaswhite\Geonames\Models\Code::class, $countrySubdivision->getCode( ) );
    }

    public function testSettersAndGetters( )
    {
        $countrySubdivision = new \Lukaswhite\Geonames\Models\CountrySubdivision( );
        $countrySubdivision->setCountryCode( 'AT' );
        $this->assertEquals( 'AT', $countrySubdivision->getCountryCode( ) );
        $countrySubdivision->setCountryName( 'Austria' );
        $this->assertEquals( 'Austria', $countrySubdivision->getCountryName( ) );
        $countrySubdivision->setAdminCode1( '07' );
        $this->assertEquals( '07', $countrySubdivision->getAdminCode1( ) );
        $countrySubdivision->setAdminName1( 'Tyrol' );
        $this->assertEquals( 'Tyrol', $countrySubdivision->getAdminName1( ) );
        $countrySubdivision->setDistance( 0.4 );
        $this->assertEquals( 0.4, $countrySubdivision->getDistance( ) );
        $countrySubdivision->getCode( )->setName( 7 );
        $this->assertEquals( 7, $countrySubdivision->getCode( )->getName( ) );
        $countrySubdivision->getCode( )->setLevel( 1 );
        $this->assertEquals( 1, $countrySubdivision->getCode( )->getLevel( ) );
        $countrySubdivision->getCode( )->setType( 'ISO3166-2' );
        $this->assertEquals( 'ISO3166-2', $countrySubdivision->getCode( )->getType( ) );
    }

    public function testGettingStringRepresentation( )
    {
        $countrySubdivision = new \Lukaswhite\Geonames\Models\CountrySubdivision( );
        $countrySubdivision->setCountryName( 'Austria' );
        $this->assertEquals( 'Austria', (string ) $countrySubdivision );
        unset( $countrySubdivision );

        $countrySubdivision = new \Lukaswhite\Geonames\Models\CountrySubdivision( );
        $countrySubdivision->setCountryName( 'Austria' );
        $countrySubdivision->setAdminName1( 'Tyrol' );
        $this->assertEquals( 'Tyrol, Austria', (string ) $countrySubdivision );
        unset( $countrySubdivision );
    }
}