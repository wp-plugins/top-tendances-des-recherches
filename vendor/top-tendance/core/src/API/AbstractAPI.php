<?php

namespace Orange\Partner\Core\API;

use Orange\Partner\Core\Cache;

abstract class AbstractAPI
{
    private
        $cacheDriver,
        $caching,
        $request,
        $errors;
    
    public function __construct()
    {
        // initialize
        $this->disableCaching();
        $this->setCacheDriver(new Cache\Driver\FileSystem());
        $this->errors = array();
    }
    
    /**
     * @param Cache\CacheInterface $cacheDriver
     */
    public function setCacheDriver(Cache\CacheInterface $cacheDriver)
    {
        $this->cacheDriver = $cacheDriver;
    }
    
    /**
     * @return \Orange\Partner\Core\Cache\CacheInterface
     */
    protected function getCacheDriver()
    {
        return $this->cacheDriver;
    }
    
    /**
     * caching
     */
    public function enableCaching()
    {
        $this->caching = true;
        
        return $this;
    }
    
    public function disableCaching()
    {
        $this->caching = false;
        
        return $this;
    }
    
    protected function isCacheEnabled()
    {
        return $this->caching;
    }
    
    /**
     * @param \CMS\API\RequestInterface $request
     */
    public function setUniqueRequest(\CMS\API\RequestInterface $request)
    {
        $this->request = $request;
        
        return $this;
    }
    
    protected function useUniqueRequest()
    {
        if (!$this->request instanceof \CMS\API\RequestInterface) {
            return false;
        }
        
        return true;
    }
    
    /**
     * @return \CMS\API\RequestInterface
     */
    protected function getRequest()
    {
        if ($this->useUniqueRequest()) {
            return $this->request;
        }
        
        return new \CMS\API\Request();
    }
    
    protected function addError($error)
    {
        $this->errors[] = $error;
    }
    
    public function getErrors()
    {
        return $this->errors;
    }
}
