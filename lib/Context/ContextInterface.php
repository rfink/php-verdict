<?php

/**
 * 
 */

namespace Verdict\Context;

interface ContextInterface
{
    /**
     * Get our value with the given key
     * @param string $key
     * @return string
     */
    public function get_value($key);
    
    /**
     * Set value with the given key/val
     * @param string $key
     * @param mixed $value
     * @return ContextInterface
     */
    public function set_value($key, $value);
}
