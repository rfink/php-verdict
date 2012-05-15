<?php

/**
 * "Number" type for verdict properties.
 * @author Ryan Fink <ryanjfink@gmail.com>
 * @since  May 15, 2012
 */

namespace Verdict\Context\Property\Type\NumberType;

class NumberType implements TypeInterface
{
    /**
     * @includeDoc
     */
    public function isRestrictedSet()
    {
        return true;
    }

    /**
     * @includeDoc
     */
    public function getExcludedDrivers()
    {
        return array(
            'StringContains',
            'StringNotContains',
            'LengthOf',
            'RegEx'
        );
    }
    
    /**
     * @includeDoc
     */
    public function getIncludedDrivers()
    {
        return array();
    }
}
