<?php

/**
 * Compile our configuration to a not equals clause.
 * @author  Ryan Fink <rfink@redventures.net>
 * @since   April 16, 2012
 */

namespace Saiku\Filter\Comparison;

use Saiku\Filter\FilterInterface;

class NotEquals extends ComparisonAbstract implements FilterInterface
{
	/**
	 * Required parameters for operation
	 * @var array
	 */
	protected $requiredParams = array(
		'contextKey',
		'configValue'
	);

	/**
	 * 
	 * @return DOMElement
	 */
	public function toMDX()
	{
		
	}
}
