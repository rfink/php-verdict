<?php

/**
 * Generic implementation of a context property, uses callbacks for
 *   getValue and getSource.
 * @author Ryan Fink <ryanjfink@gmail.com>
 * @since  May 14, 2012
 */

namespace Verdict\Context\Property;

use Verdict\Context\ContextInterface,
    ReflectionFunction;

class Generic implements PropertyInterface, ContextInterface
{
    /**
     * Array of object properties
     * @var array
     */
    private $properties = array();
    
    /**
     * Constructor
     * @param array $properties 
     */
    public function __construct(array $properties = array())
    {
        $this->properties = array_merge(array(
            'value' => null,
            'getSource' => null,
            'getValue' => null,
            'type' => 'string'
        ), $properties);
    }

    /**
     * @inheritDoc
     */
    public function getValue($key)
    {
        if (is_callable($this->properties['getValue']))
        {
            $reflect = new ReflectionFunction($this->properties['getValue']);
            return $reflect->invoke($this);
        }
        return $this->properties['value'];
    }

    /**
     * @inheritDoc
     */
    public function setValue($key, $value)
    {
        if (isset($this->properties[$key]))
        {
            $this->properties[$key]->setValue($key, $value);
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSource()
    {
        if (is_callable($this->properties['getSource']))
        {
            $reflect = new ReflectionFunction($this->properties['getSource']);
            return $reflect->invoke($this);
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getType()
    {
        return $this->properties['type'];
    }
}
