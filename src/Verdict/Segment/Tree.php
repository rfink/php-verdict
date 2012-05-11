<?php

/**
 * 
 */

namespace Verdict\Segment;

use Verdict\Filter\FilterInterface,
    InvalidArgumentException;

class Tree implements SegmentInterface
{
    private $children = array();
    
    private $parent = null;
    
    private $segmentName = null;
    
    private $segmentId = null;
    
    private $condition = null;
    
    private $counter = null;
    
    public function __construct(FilterInterface $condition = null)
    {
        $this->condition = $condition;
    }
    
    public function setSegmentName($name)
    {
        $this->segmentName = $name;
        return $this;
    }
    
    public function setSegmentId($segmentId)
    {
        $this->segmentId = $segmentId;
        return $this;
    }
    
    public function setParent(Tree $parent)
    {
        $this->parent = $parent;
        return $this;
    }
    
    public function addChild(Tree $child)
    {
        $this->children[] = $child;
        return $this;
    }
    
    public function setChildren(array $children)
    {
        /* @var $child Tree */
        foreach ($children as $child)
        {
            $this->addChild($child);
        }
        return $this;
    }
    
    public function getChildren()
    {
        return $this->children;
    }
    
    public function setCounter($counter)
    {
        $this->counter = (integer) $counter;
    }
    
    public function getCounter()
    {
        return $this->counter;
    }
    
    public function evaluateCondition()
    {
        if (isset($this->condition))
        {
            return $this->condition->evaluate();
        }
        return true;
    }
    
    public function isLeafNode()
    {
        return (boolean) count($this->children);
    }
    
    public function each($callback)
    {
        if (!is_callable($callback))
        {
            throw new InvalidArgumentException('Callback must be a valid callable function');
        }
        $callback($this);
        /* @var $child Tree */
        foreach ($this->children as $child)
        {
            $child->each($callback);
        }
    }
    
    public function getLeafNode()
    {
        $path = array();
        function walkTree(Tree $segment)
        {            
            if (!$segment->evaluateCondition())
            {
                return null;
            }
            if ($segment->isLeafNode())
            {
                return $segment;
            }
            $path[] = $segment;
            /* @var $child Tree */
            foreach ($segment->getChildren() as $child)
            {
                $val = $child->evaluateCondition();
                if (isset($val))
                {
                    return $val;
                }
            }
            // Branch evaluated to false, pop the last path off
            array_pop($path);
        }
        $node = walkTree($this);
        return array(
            'path' => $path,
            'node' => $node
        );
    }
    
    public function getAllLeaves()
    {
        $segments = array();
        if ($this->isLeafNode())
        {
            $segments[] = $this;
        }
        $this->each(function($segment) use (& $segments) {
            if ($segment->isLeafNode())
            {
                $segments[] = segment;
            }
        });
        return $segments;
    }
    
    public function enumerate()
    {
        $counter = 0;
        $this->setCounter($counter);
        $this->each(function($segment) use (& $counter) {
            $segment->setCounter(++$counter);
        });
        return $counter;
    }
    
}
