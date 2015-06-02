<?php

namespace Orange\Partner\Core\Cache\Driver;

use Orange\Partner\Core\Cache\CacheInterface;

class FileSystem implements CacheInterface
{
    const
        DEFAULT_DIRECTORY = './cache';
    
    private
        $cacheFilesDirectory;
    
    public function __construct($directory = self::DEFAULT_DIRECTORY)
    {
        $this->setCacheFilesDirectory($directory);
    }
    
    public function setCacheFilesDirectory($cacheFilesDirectory)
    {
        $this->cacheFilesDirectory = $cacheFilesDirectory;
    }
    
    public function get($key)
    {
        if (!is_file($this->getFilePath($key))) {
            throw new \LogicException(sprintf(
                'Unable to find the cache file "%s"',
                $this->getFilePath($key)
            ));
        }
        
        $value = file_get_contents($this->getFilePath($key));
        
        if ($value === false) {
            throw new \LogicException(sprintf(
                'Unable to get the cache file "%s"',
                $this->getFilePath($key)
            ));
        }
        
        return unserialize($value);
    }
    
    public function set($key, $value)
    {
        if (file_put_contents($this->getFilePath($key), serialize($value)) === false) {
            throw new \LogicException(sprintf(
                'Unable to set the value to the cache file "%s"',
                $this->getFilePath($key)
            ));
        }
    }
    
    public function isValid($key)
    {
        if (!is_file($this->getFilePath($key))) {
            return false;
        }
        
        $fileDateTime = new \DateTime();
        $fileDateTime
            ->setTimestamp(filemtime($this->getFilePath($key)))
            ->modify(sprintf(
                '+%d seconds',
                $this->getTTL($key)
            ));
        
        if (new \DateTime() > $fileDateTime) {
            return false;
        }
        
        return true;
    }
    
    public function getTTL($key)
    {
        return CacheInterface::DEFAULT_TTL;
    }
    
    private function getFilePath($key)
    {
        if (!is_dir($this->cacheFilesDirectory)) {
            throw new \LogicException(sprintf(
                'Invalid cache files directory "%s"',
                $this->cacheFilesDirectory
            ));
        }
        
        return sprintf(
            '%s/%s',
            $this->cacheFilesDirectory,
            sha1($key)
        );
    }
}