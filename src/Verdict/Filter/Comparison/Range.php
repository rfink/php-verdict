<?php

/**
 * Compile our configuration to a range clause
 * @author  Ryan Fink <rfink@redventures.net>
 * @since   April 16, 2012
 */

namespace Verdict\Filter\Comparison;

use Verdict\Filter\FilterInterface;

class Range extends ComparisonAbstract implements FilterInterface {
	/**
	 * Required parameters for operation
	 * @var array
	 */
	protected $requiredParams = array(
		'min',
        'max'
	);

    /**
     * 
     */
	public function evaluate() {
        $val = $this->context->getValue($this->contextKey);
		return $val >= $this->params['min'] && $val <= $this->params['max'];
	}
}
