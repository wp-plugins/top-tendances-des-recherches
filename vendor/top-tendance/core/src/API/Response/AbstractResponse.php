<?php

namespace Orange\Partner\Core\API\Response;

abstract class AbstractResponse
{
    protected
        $responseDateTime,
        $responseBody,
        $messages;
    
    public function __construct(\CMS\API\Response $response)
    {
        $this->responseDateTime = $response->getDateTime();
        $this->responseBody     = $response->getBody();
        $this->messages = array();
    }
    
    public function isValid()
    {
        if (!$this->isValidProperties()) {
            return false;
        }
        
        if (!$this->isValidPropertiesType()) {
            return false;
        }
        
        if (!$this->isValidPropertiesData()) {
            return false;
        }
        
        return true;
    }
    
    public function getProperty($property)
    {
        if (!property_exists($this->responseBody, $property)) {
            throw new \LogicException(sprintf(
                'Unable to get the property "%s" on the response body',
                $property
            ));
        }
        
        return $this->responseBody->$property;
    }
    
    public function getMessages()
    {
        return sprintf(
            'Messages: %s',
            implode(', ', $this->messages)
        );
    }
    
    private function isValidProperties()
    {
        $valid = true;
        
        foreach ($this->getProperties() as $property) {
            if (!property_exists($this->responseBody, $property)) {
                $this->messages[] = sprintf(
                    'Unable to find the required property "%s" on the response body',
                    $property
                );
                
                $valid = false;
            }
        }
        
        return $valid;
    }
    
    abstract protected function getProperties();
    
    private function isValidPropertiesType()
    {
        $valid = true;
        
        foreach ($this->getPropertiesType() as $property => $type) {
            if (gettype($this->getProperty($property)) !== $type) {
                $this->messages[] = sprintf(
                    'Invalid property "%s": must be "%s" type, "%s" given',
                    $property,
                    $type,
                    gettype($this->getProperty($property))
                );
                
                $valid = false;
            }
        }
        
        return $valid;
    }
    
    abstract protected function getPropertiesType();
    
    private function isValidPropertiesData()
    {
        $valid = true;
        
        foreach ($this->getPropertiesData() as $property => $data) {
            if ($this->getProperty($property) !== $data) {
                $this->messages[] = sprintf(
                    'Invalid property "%s": must be same as "%s", "%s" given',
                    $property,
                    $data,
                    $this->getProperty($property)
                );
                
                $valid = false;
            }
        }
        
        return $valid;
    }
    
    abstract protected function getPropertiesData();
}
