<?php namespace Lukaswhite\Geonames\Models;

/**
 * Class AdministrativeArea
 *
 * Represents an administrative area.
 *
 * @package Lukaswhite\Geonames\Models
 */
class AdministrativeArea
{
    /**
     * The admin code
     *
     * @var mixed
     */
    private $code;

    /**
     * The name
     *
     * @var string
     */
    private $name;

    /**
     * The level
     *
     * @var int
     */
    private $level;

    /**
     * The parent area
     *
     * @var AdministrativeArea
     */
    private $parent;

    /**
     * The children of this admin code; i.e. the admin codes that have
     * this code as a parent, or to put it another way, the ones physically located
     * within this administrative area.
     *
     * @var array
     */
    private $children;

    /**
     * AdminCode constructor.
     *
     * @param mixed $code
     * @param int $level
     * @param string $name
     */
    public function __construct( $code, $level, $name = null )
    {
        $this->level = $level;
        $this->code = $code;
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return AdministrativeArea
     */
    public function setName( $name )
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     * @return AdministrativeArea
     */
    public function setParent( $parent )
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param mixed $children
     * @return AdministrativeArea
     */
    public function setChildren( $children )
    {
        $this->children = $children;
        return $this;
    }

    /**
     * Create a string representation of this alternate name; simply returns the actual name.
     *
     * @return string
     */
    public function __toString( )
    {
        return $this->code;
    }

}