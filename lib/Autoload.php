<?php

/**
 * 
 */

namespace Verdict;

class Autoload
{
    /**
     * Autoload our verdict classes
     * @param type $class 
     * @return boolean
     */
    public function loadClass($class)
    {
        $classLocation = explode('\\', $class);
        // We don't have a "verdict" folder, so just get rid of this
        if ($classLocation[0] === 'Verdict')
        {
            array_shift($classLocation);
        }
        $classLocation = implode(DIRECTORY_SEPARATOR, $classLocation) . '.php';
        if (is_readable($classLocation))
        {
            require_once($classLocation);
            return true;
        }
        return false;
    }
}
