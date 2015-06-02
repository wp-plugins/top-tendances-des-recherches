<?php

namespace CMS\API;

interface MessageInterface
{
    public function addHeader($name, $value);
    
    public function getHeaders();
    
    public function setBody($body);
    
    public function getBody();
}
