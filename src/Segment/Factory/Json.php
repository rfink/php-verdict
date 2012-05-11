<?php

/**
 * 
 */

namespace Verdict\Segment\Factory;

use Verdict\Segment\Tree,
    Verdict\Context\ContextInterface,
    Verdict\Filter\Factory\Json as FilterFactory;

class Json
{
    
    /**
     *
     * @var type 
     */
    private $data = array();
    
    /**
     *
     * @var type 
     */
    private $context = null;
    
    /**
     *
     * @param array $data
     * @param ContextInterface $context 
     */
    public function __construct(array $data, ContextInterface $context)
    {
        // TODO: Allow data to be a json string
        $this->data = $data;
        $this->context = $context;
    }
    
    /**
     * 
     * @return Tree
     */
    public function build()
    {
        function doBuild(array $data, ContextInterface $context)
        {
            $filter = new FilterFactory($context, $data);
            $tree = new Tree($filter);
            $tree->setSegmentName($data['segmentName']);
            $tree->setSegmentId($data['segmentId']);
            if (is_array($data['children']))
            {
                foreach ($data['children'] as $child)
                {
                    $segment = doBuild($child, $context);
                    $segment->setParent($tree);
                    $tree->addChild($segment);
                }
            }
        }
        return doBuild($this->data, $this->context);
    }
    
}
