<?php

/**
 * Compile our configuration to a string not contains clause.
 * @author  Ryan Fink <rfink@redventures.net>
 * @since   April 16, 2012
 */

namespace Verdict\Filter\Comparison;

use Verdict\Filter\FilterInterface;

class StringNotContains extends ComparisonAbstract implements FilterInterface
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
	public function evaulate()
	{
		return (stripos($this->context->getValue($this->contextKey), $this->params['configValue']) === false);
	}
}

