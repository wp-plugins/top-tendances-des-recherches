<?php

namespace CMS\API;

interface RequestInterface extends MessageInterface
{
    const
        POST_METHOD = 'POST',
        GET_METHOD  = 'GET';
    
    const
        DEFAULT_AUTHORIZATION = 'Basic';
    
    const
        DEFAULT_TIMEOUT = 3;
    
    public function post($url);
    
    public function get($url);
}
