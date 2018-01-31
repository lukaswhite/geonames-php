<?php

use Lukaswhite\Geonames\Models\AlternateName;

class AlternateNameTest extends PHPUnit_Framework_TestCase{

    public function testConstructor( )
    {
        $name = new AlternateName( 'ab', 'Лондан' );
        $this->assertEquals( 'ab', $name->getLanguage( ) );
        $this->assertEquals( 'Лондан', $name->getName( ) );
        $this->assertFalse( $name->isPreferred( ) );
        $this->assertFalse( $name->isShort( ) );
        $this->assertFalse( $name->isLink( ) );
        $this->assertFalse( $name->isAbbreviation( ) );
        $this->assertFalse( $name->isPseudoLanguage( ) );
    }

    public function testPreferredNames( )
    {
        $name = new AlternateName( 'en', 'London', true );
        $this->assertTrue( $name->isPreferred( ) );
    }

    public function testShortNames( )
    {
        $name = new AlternateName( 'it', 'San Gallo', false, true );
        $this->assertTrue( $name->isShort( ) );
    }

    public function testLinks( )
    {
        $name = new AlternateName( 'link', 'http://en.wikipedia.org/wiki/London' );
        $this->assertEquals( 'http://en.wikipedia.org/wiki/London', $name->getName( ) );
        $this->assertTrue( $name->isLink( ) );
        $this->assertTrue( $name->isPseudoLanguage( ) );
    }

    public function testAbbreviations( )
    {
        $name = new AlternateName( 'abbr', 'USA' );
        $this->assertEquals( 'USA', $name->getName( ) );
        $this->assertTrue( $name->isAbbreviation( ) );
        $this->assertTrue( $name->isPseudoLanguage( ) );
    }

    public function testStringRepresentations( )
    {
        $name = new AlternateName( 'ab', 'Лондан' );
        $this->assertEquals( 'Лондан', $name->__toString( ) );
        $this->assertEquals( 'Лондан', ( string ) $name );
    }

}