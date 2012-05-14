<?php

/**
 * Service used to discover available comparison objects.
 * @return Ryan Fink <ryanjfink@gmail.com>
 * @since  May 14, 2012
 */

namespace Verdict\Service\Comparison;

use DirectoryIterator,
    ReflectionClass;

class Discover
{
    /**
     * Cache of comparison objects available
     * @var array
     */
    private $comparisonCache = array();
    /**
     * Our directory array that points to our comparison directory
     * @var array
     */
    private $comparisonDir = array(
        '..',
        '..',
        'Filter',
        'Comparison'
    );
    
    /**
     * Get our comparison data by scanning our comparison directory
     * @return array
     */
    public function getComparisons()
    {
        // Add our current directory pointer to the array (can't be done in property definition)
        array_unshift($this->comparisonDir, dirname(__FILE__));
        // Try to do this platform independent
        $comparisonDir = implode(DIRECTORY_SEPARATOR, $this->comparisonDir);
        if (!count($this->comparisonCache))
        {
            // Iterate our directory looking for comparison classes
            foreach (new DirectoryIterator($comparisonDir) as $file)
            {
                // Skip sub-dirs and dot files
                if ($file->isDir() || $file->isDot())
                {
                    continue;
                }
                $fileName = $file->getFilename();
                $className = str_replace('.php', '', $fileName);
                $reflectClass = new ReflectionClass('\\Verdict\\Filter\\Comparison\\' . $className);
                // Skip interfaces and abstracts
                if (!$reflectClass->isInstantiable() || !$reflectClass->implementsInterface('\\Verdict\\Filter\\Comparison\\ComparisonInterface'))
                {
                    continue;
                }
                $reflectMethod = $reflectClass->getMethod('getDisplay');
                $this->comparisonCache[$className] = $reflectMethod->invoke(null);
            }
        }
        return $this->comparisonCache;
    }
}
