<?php

/**
 * Generic implementation of a context property, uses callbacks for
 *   getValue and getSource.
 * @author Ryan Fink <ryanjfink@gmail.com>
 * @since  May 14, 2012
 */

namespace Verdict\Context\Property;

use Verdict\Context\ContextInterface,
    Verdict\Context\Property\Type\StringType,
    ReflectionFunction,
    BadMethodCallException;

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
        $type = isset($properties['type']) ? $properties['type'] : new StringType();
        $this->properties = array_merge(array(
            'value' => null,
            'getSource' => is_callable(array($type, 'getSource')) ? array($type, 'getSource') : null,
            'getValue' => null,
            'type' => $type,
            'isRestrictedSet' => $type->isRestrictedSet(),
            'excludedDrivers' => $type->getExcludedDrivers(),
            'includedDrivers' => $type->getIncludedDrivers()
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
    public function getSource($params)
    {
        if (is_callable($this->properties['getSource']))
        {
            $reflect = new ReflectionFunction($this->properties['getSource']);
            return $reflect->invoke($params);
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
    
    /**
     * @inheritDoc
     */
    public function getProperty($name)
    {
        if (isset($this->properties[$name]))
        {
            return $this->properties[$name];
        }
        return null;
    }
    
    /**
     * @inheritDoc
     */
    public function getProperties()
    {
        throw new BadMethodCallException('Not available for properties');
    }
}
