<?php

namespace CMS\API;

class Message implements MessageInterface
{
    private
        $headers,
        $body;
    
    public function __construct()
    {
        // initialize
        $this->headers = array();
        $this->body    = null;
    }
    
    public function addHeader($name, $value)
    {
        $this->headers[$name] = sprintf(
            '%s: %s',
            $name,
            $value
        );
        
        return $this;
    }
    
    public function getHeaders()
    {
        return $this->headers;
    }
    
    public function setBody($body)
    {
        $this->body = $body;
        
        return $this;
    }
    
    public function getBody()
    {
        return $this->body;
    }
}
