<?php

/**
 * Compile our configuration to a "length of" clause.
 * @author  Ryan Fink <rfink@redventures.net>
 * @since   April 16, 2012
 */

namespace Verdict\Filter\Comparison;

use Verdict\Filter\FilterInterface,
    InvalidArgumentException;

class LengthOf extends ComparisonAbstract implements FilterInterface
{
	/**
	 * Required parameters for operation
	 * @var array
	 */
	protected $requiredParams = array(
		'configValue'
	);

    /**
     * 
     */
	public function evaulate()
	{
        $val = $this->context->getValue($this->contextKey);
        if (is_string($val))
        {
            return strlen($val) == $this->params['configValue'];
        }
        else if (is_array($val))
        {
            return count($val) == $this->params['configValue'];
        }
        throw new InvalidArgumentException('Value supplied to "lengthOf" must be an array or a string');
	}
}

