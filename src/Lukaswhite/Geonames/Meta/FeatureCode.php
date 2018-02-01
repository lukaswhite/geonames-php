<?php namespace Lukaswhite\Geonames\Meta;

class FeatureCode
{
    /**
     * The code
     *
     * @var string
     */
    private $code;

    /**
     * The name
     *
     * @var string
     */
    private $name;

    /**
     * The description
     *
     * @var string
     */
    private $description;

    /**
     * FeatureCode constructor.
     *
     * @param string $code
     * @param string $name
     * @param string $description
     */
    public function __construct( $code, $name = null, $description = null )
    {
        $this->code = $code;
        if ( $name ) {
            $this->name = $name;
        }
        if ( $description ) {
            $this->description = $description;
        }
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode( string $code )
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName( string $name )
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription( string $description )
    {
        $this->description = $description;
    }

    /**
     * Create a string representation of this feature code
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

}