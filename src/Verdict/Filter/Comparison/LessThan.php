<?php

/**
 * Compile our configuration to an equals clause
 * @author  Ryan Fink <rfink@redventures.net>
 * @since   April 16, 2012
 */

namespace Verdict\Filter\Comparison;

use Verdict\Filter\FilterInterface;

class LessThan extends ComparisonAbstract implements FilterInterface {
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
	public function evaulate() {
		return $this->context->getValue($this->contextKey) < $this->params['configValue'];
	}
}
