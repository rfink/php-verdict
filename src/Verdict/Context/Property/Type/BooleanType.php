<?php

/**
 * 
 */

namespace Verdict\Context\Property\Type;

class BooleanType implements TypeInterface
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
    
    /**
     * 
     */
    public function getSource()
    {
        return array(
            array(
                'label' => 'true',
                'value' => 1
            ),
            array(
                'label' => 'false',
                'value' => 0
            )
        );
    }
}
