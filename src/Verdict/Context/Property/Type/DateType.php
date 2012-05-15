<?php

/**
 * 
 */

namespace Verdict\Context\Property\Type;

class DateType implements TypeInterface
{
    public function isRestrictedSet()
    {
        return true;
    }
    
    public function getExcludedDrivers()
    {
        
    }
    
    public function getIncludedDrivers()
    {
        
    }
}
