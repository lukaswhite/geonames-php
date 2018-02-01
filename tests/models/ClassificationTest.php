<?php

use Lukaswhite\Geonames\Models\Classification;

class ClassificationTest extends PHPUnit_Framework_TestCase{

    public function testSettersAndGetters( )
    {
        $classification = new Classification( 'P' );
        $this->assertEquals( 'P', $classification->getClass( ) );
        $this->assertNull( $classification->getCode( ) );
        $classification->setCode( 'PPL' );
        $this->assertEquals( 'PPL', $classification->getCode( ) );
        unset( $classification );
        $classification = new Classification( 'P' );
        $classification->setClass( 'A' );
        $this->assertEquals( 'A', $classification->getClass( ) );
        $classification->setClassName( 'country, state, region,...' );
        $this->assertEquals( 'country, state, region,...', $classification->getClassName( ) );
        $classification->setCodeName( 'first-order administrative division' );
        $this->assertEquals( 'first-order administrative division', $classification->getCodeName( ) );
    }

}