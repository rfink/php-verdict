<?php

/**
 * 
 */

namespace Verdict\Filter\Factory;

interface FactoryInterface
{
    /**
     * Build our verdict filter object and return it
     * @return FilterInterface
     */
    public function build();
}
