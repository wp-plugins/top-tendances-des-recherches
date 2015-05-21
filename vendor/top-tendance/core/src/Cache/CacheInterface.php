<?php

namespace Orange\Partner\Core\Cache;

interface CacheInterface
{
    const
        DEFAULT_TTL = 60;
    
    public function get($key);
    
    public function set($key, $value);
    
    public function isValid($key);
    
    public function getTTL($key);
}