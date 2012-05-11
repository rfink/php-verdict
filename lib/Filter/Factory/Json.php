<?php

/**
 * 
 */

namespace Verdict\Filter\Factory;

use Verdict\Context\ContextInterface,
    ArrayIterator,
    ReflectionClass,
    JSON_ERROR_NONE,
    RuntimeException,
    InvalidArgumentException;

class Json implements FactoryInterface
{
    /**
     * Our context object
     * @var ContextInterface
     */
    private $context = null;

    /**
     * Data array
     * @var array
     */
    private $data = array();
    
    /**
     * Instantiate our object
     * @param type $json 
     */
    public function __construct(ContextInterface $context, $json)
    {
        // Quick type checking
        if (!is_string($json) || !is_array($json))
        {
            throw new InvalidArgumentException('JSON must be a string or array');
        }
        if (is_string($json))
        {
            $this->data = json_decode($json, true);
            $lastError = json_last_error();
            if ($lastError !== JSON_ERROR_NONE)
            {
                throw new InvalidArgumentException('Error decoding json - ' . $lastError);
            }
        }
        else
        {
            $this->data = $json;
        }
        $this->context = $context;
    }
    
    /**
     * Build our object and return
     * @return FilterInterface
     */
    public function build()
    {
        return $this->getObject($this->data);
    }
    
    /**
     * Make this its own method, to allow easier recursion
     * @param array $data 
     * @return FilterInterface
     */
    private function getObject(array $data)
    {
        if (!isset($data['nodeType']) || !isset($data['nodeDriver']))
        {
            throw new RuntimeException('Node did not contain a node type or a node driver');
        }
        switch (strtolower($data['nodeType']))
        {
            case 'composite':
                $nodes = new ArrayIterator();
                foreach ((array) $data['children'] as $child)
                {
                    $nodes->append($this->getObject($child));
                }
                $reflect = new ReflectionClass('\\Verdict\\Filter\\Composite\\' . ucfirst($data['nodeDriver']));
                return $reflect->newInstance($nodes);
                break;
            case 'comparison':
                $reflect = new ReflectionClass('\\Verdict\\Filter\Comparison\\' . ucfirst($data['nodeDriver']));
                return $reflect->newInstance($this->context);
                break;
            default:
                throw new RuntimeException('nodeType must be either composite or comparison');
        }
    }
}
