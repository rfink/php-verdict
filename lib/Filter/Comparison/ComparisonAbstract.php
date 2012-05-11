<?php

/**
 * 
 */

namespace Verdict\Filter\Comparison;

use Verdict\Context\ContextInterface,
	ArrayIterator,
	InvalidArgumentException;

abstract class ComparisonAbstract
{
	/**
	 * Array of parameters
	 * @var ArrayIterator
	 */
	protected $params;
	/**
	 * Array of required params (extended in individual comparison classes)
	 * @var array
	 */
	protected $requiredParams = array();

	/**
	 * Instantiate with dependencies
	 * @param CubeAbstract  $cube
	 * @param ArrayIterator $params
	 */
	public function __construct(ContextInterface $context, ArrayIterator $params)
    {
		$this->params = $params;
		// Iterate and make sure we have all the necessary parameters
		foreach ($this->requiredParams as $requiredParam)
        {
			if (!isset($params[$requiredParam]))
            {
				throw new InvalidArgumentException('Required params ' . $requiredParam . ' was not found');
			}
		}
	}

}
