<?php

/**
 * Compile our configuration to a greater than clause.
 * @author  Ryan Fink <rfink@redventures.net>
 * @since   April 16, 2012
 */

namespace Verdict\Filter\Comparison;

use Verdict\Filter\FilterInterface;

class GreaterThan extends ComparisonAbstract implements FilterInterface
{
    /**
     * @inheritDoc
     */
	protected $requiredParams = array(
		'configValue'
	);

    /**
     * @inheritDoc
     */
	public function evaluate()
    {
		return $this->context->getValue($this->contextKey) > $this->params['configValue'];
	}
}
