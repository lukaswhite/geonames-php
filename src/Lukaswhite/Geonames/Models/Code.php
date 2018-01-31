<?php namespace Lukaswhite\Geonames\Models;

use Lukaswhite\Geonames\Traits\Models\HasName;

/**
 * Class Code
 *
 * Represents a code
 *
 * @package Lukaswhite\Geonames\Models
 */
class Code
{
    use HasName;

    /**
     * The level
     *
     * @var integer
     */
    private $level = 0;

    /**
     * The type (e.g. ISO3166-2)
     *
     * @var string
     */
    private $type;

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $level
     * @return Code
     */
    public function setLevel( int $level ): Code
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Code
     */
    public function setType( string $type ): Code
    {
        $this->type = $type;
        return $this;
    }
}