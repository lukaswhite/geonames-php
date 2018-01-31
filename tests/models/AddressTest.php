<?php

use Lukaswhite\Geonames\Models\Address;

class AddressTest extends PHPUnit_Framework_TestCase{

    public function testFormatStreetWithNumber( )
    {
        $address = new Address(  );
        $address->setStreetNumber( '123' );
        $address->setStreet( 'Something Street' );
        $this->assertEquals( '123 Something Street', ( string ) $address );
        unset( $address );
    }

    public function testFormatStreetWithoutNumber( )
    {
        $address = new Address(  );
        $address->setStreet( 'Something Street' );
        $this->assertEquals( 'Something Street', ( string ) $address );
        unset( $address );
    }

}