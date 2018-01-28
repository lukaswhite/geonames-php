<?php namespace Lukaswhite\Geonames\Traits\Models;

/**
 * Trait HasName
 *
 * @package Lukaswhite\Geonames\Traits\Models
 */
trait HasName
{
    /**
     * The name
     *
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName( string $name )
    {
        $this->name = $name;
        return $this;
    }

}