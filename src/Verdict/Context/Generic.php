<?php

/**
 * Generic implementation of a context object, use this if you have a one-off use case
 *   that doesn't have any re-usability.
 * @author Ryan Fink <ryanjfink@gmail.com>
 * @since  May 14, 2012
 */

namespace Verdict\Context;

use Verdict\Context\Property\PropertyInterface,
    Verdict\Context\Property\Generic as GenericProperty;

class Generic implements ContextInterface
{
    /**
     * Our delimiter between nested properties
     * @var string
     */
    private $delimiter = '::';
    /**
     * Array of properties for the generic object
     * @var array 
     */
    private $properties = array();
    
    /**
     * Convenience constructor, pass in an array for this to auto-create a generic nested context object
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        foreach ($data as $key => $value)
        {
            // If we have a property, treat it as such
            if ($value instanceof PropertyInterface)
            {
                $this->addElement($key, $value);
            }
            // Otherwise, we have another context
            else
            {
                $this->addElement($key, new static($value));
            }
        }
    }
    
    /**
     * Get value (recursive)
     * @param type $key
     * @return mixed
     */
    public function getValue($key)
    {
        $ref = $this->getPropertyReference($key);
        return $ref->getValue($key);
    }
    
    /**
     * Get context/property object recursively (using the delimiter to inspect into nested objects)
     * @param string $key
     * @return PropertyInterface
     */
    public function property($key)
    {
        $ref = $this->getPropertyReference($key);
        if ($ref instanceof PropertyInterface)
        {
            return $ref;
        }
        return null;
    }
    
    /**
     * Get direct property reference
     * @param string $key
     * @return ContextInterface
     */
    public function getProperty($key)
    {
        if (isset($this->properties[$key]))
        {
            return $this->properties[$key];
        }
        return null;
    }
    
    /**
     * Set value (allow this to be recursive, by using a property name separated by the delimiter)
     * @param string $key
     * @param mixed $value
     * @return Generic 
     */
    public function setValue($key, $value)
    {
        $ref = $this->getPropertyReference($key);
        $ref->setValue($name, $value);
        return $this;
    }
    
    /**
     * Add a context/property element
     * @param ContextInterface $element
     * @return Generic 
     */
    public function addElement($key, ContextInterface $element)
    {
        $this->properties[$key] = $element;
        return $this;
    }
    
    /**
     * Recursive method for digging into a key and returning the nested reference
     * @param string $key
     * @return PropertyInterface
     */
    private function getPropertyReference($key)
    {
        $props = explode($this->delimiter, $key);
        $name = array_shift($props);
        $ref = $this->properties[$name];
        while($name = array_shift($props))
        {
            $ref = $ref->getProperty($name);
        }
        return $ref;
    }
}
