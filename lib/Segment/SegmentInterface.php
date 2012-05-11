<?php

/**
 * 
 */

namespace Verdict\Segment;

interface SegmentInterface
{
    /**
     * 
     */
    public function isLeafNode();
    
    /**
     * 
     */
    public function getLeafNode();
    
    /**
     * 
     */
    public function getAllLeaves();
}