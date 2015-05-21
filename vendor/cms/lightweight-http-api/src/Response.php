<?php

namespace CMS\API;

class Response extends Message implements ResponseInterface
{
    private
        $statusCode,
        $dateTime,
        $contentType;
    
    public function __construct()
    {
        // initialize
        parent::__construct();
        $this->statusCode  = null;
        $this->dateTime    = new \DateTime();
        $this->contentType = null;
    }
    
    public function build(array $headers, $body)
    {
        // set headers
        $this->hydrateResponseHeaders($headers);
        
        // set raw body (after setting headers)
        $this->setRawBody($body);
    }
    
    public function buildFatalError($url)
    {
        // set the debug message
        $debugMessage = 'unknow';
        
        $error = error_get_last();
        if ($error !== null) {
            $debugMessage = $error['message'];
        }
        
        $this->setBody(sprintf(
            'Unable to get the content of "%s", error: %s',
            $url,
            $debugMessage
        ));
        
        $this->setStatusCode(ResponseInterface::ERROR_STATUS_CODE);
    }
    
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        
        return $this;
    }
    
    public function getStatusCode()
    {
        return $this->statusCode;
    }
    
    public function setDateTime(\DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
        
        return $this;
    }
    
    public function getDateTime()
    {
        return $this->dateTime;
    }
    
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        
        return $this;
    }
    
    public function getContentType()
    {
        return $this->contentType;
    }
    
    public function setRawBody($rawBody)
    {
        // application/json or application/json; charset=UTF-8 or charset=UTF-8; application/json
        if ($this->isJsonContentType()) {
            $rawBody = json_decode($rawBody);
        }
        
        $this->setBody($rawBody);
        
        return $this;
    }
    
    private function isJsonContentType()
    {
        $patternJsonContentType = sprintf(
            '~(^| )%s(;|$)~',
            ResponseInterface::JSON_CONTENT_TYPE
        );
        
        if (preg_match($patternJsonContentType, $this->getContentType()) !== 1) {
            return false;
        }
        
        return true;
    }
    
    private function hydrateResponseHeaders(array $headers)
    {
        if (empty($headers)) {
            return $this;
        }
        
        foreach ($headers as $header) {
            // status code
            if (preg_match('~^HTTP/[^ ]+ ([0-9]+) ~', $header, $result)) {
                $this->setStatusCode((int) $result[1]);
            }
            
            // date time
            if (preg_match('~^Date: (.+)$~', $header, $result)) {
                $dateTime = new \DateTime($result[1]);
                $dateTime->setTimezone(new \DateTimeZone(date_default_timezone_get()));
                
                $this->setDateTime($dateTime);
            }
            
            // content type
            if (preg_match('~^Content-Type: (.+)$~', $header, $result)) {
                $this->setContentType($result[1]);
            }
        }
        
        return $this;
    }
    
    public function isValid()
    {
        if ($this->getStatusCode() !== ResponseInterface::VALID_STATUS_CODE) {
            return false;
        }
        
        return true;
    }
    
    public function isSuccess()
    {
        if (!preg_match('~^2[0-9]{2}$~', $this->getStatusCode())) {
            return false;
        }
        
        return true;
    }
}
