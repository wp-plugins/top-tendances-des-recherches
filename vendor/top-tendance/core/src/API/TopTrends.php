<?php

namespace Orange\Partner\Core\API;

class TopTrends extends AbstractAPI
{
    const
        DEFAULT_CATEGORY = 'actu',
        DEFAULT_LIMIT    = 5;
    
    const
        CATEGORY_NAME = 'category',
        LIMIT_NAME    = 'limit';
    
    public static function isTokenValid(\DateTime $dateTime)
    {
        // adds one day to current date time
        $limit = new \DateTime();
        $limit->add(new \DateInterval('P1D'));
        
        // token date time lower than the limit date time is invalid
        if ($dateTime < $limit) {
            return false;
        }
        
        return true;
    }
    
    public function getAuthorizationToken($consumerKey)
    {
        // no cache on POST request!
        $tokenResponse = $this->getRequest()
            ->addHeader('Content-Type', 'application/x-www-form-urlencoded')
            ->addAuthorizationHeader(\CMS\API\RequestInterface::DEFAULT_AUTHORIZATION, $consumerKey)
            ->setBody(array('grant_type' => 'client_credentials'))
            ->post('https://api.orange.com/oauth/v2/token');
        
        if (!$tokenResponse->isValid()) {
            $this->addResponseErrors($tokenResponse);
            
            return null;
        }
        
        return $this->getResponseClass('Token', $tokenResponse);
    }
    
    public function getSearch($token, $category = self::DEFAULT_CATEGORY, $limit = self::DEFAULT_LIMIT)
    {
        self::isParameterValid(self::CATEGORY_NAME, $category, self::getSearchCategories());
        self::isParameterValid(self::LIMIT_NAME, $limit, self::getSearchLimits());
        
        $searchUrl = sprintf(
            'https://api.orange.com/search/v2/toptrends?%s=%s&%s=%d',
            self::CATEGORY_NAME,
            $category,
            self::LIMIT_NAME,
            $limit
        );
        
        return $this->buildResponseClassForGetRequest($searchUrl, $token, 'Search');
    }
    
    public static function getSearchCategories()
    {
        return array(
            self::DEFAULT_CATEGORY,
            'sport',
            'people',
        );
    }
    
    public static function getSearchLimits()
    {
        return array(
            3,
            self::DEFAULT_LIMIT,
            10,
            15,
            20,
        );
    }
    
    protected function buildResponseClassForGetRequest($url, $token, $className)
    {
        if ($this->isCacheEnabled()) {
            // generate cache key
            $cacheKey = strtolower(sprintf(
                '%s-%s',
                $className,
                preg_replace('~[^a-z0-9]~i', '', $url)
            ));
            
            if ($this->getCacheDriver()->isValid($cacheKey)) {
                return $this->getCacheDriver()->get($cacheKey);
            }
        }
        
        $httpResponse = $this->getRequest()
            ->addAuthorizationHeader(Response\Token::TOKEN_TYPE_VALUE, $token)
            ->get($url);
        
        if (!$httpResponse->isValid()) {
            $this->addResponseErrors($httpResponse);
            
            return null;
        }
        
        $response = $this->getResponseClass($className, $httpResponse);
        
        if ($response !== null && $this->isCacheEnabled()) {
            $this->getCacheDriver()->set($cacheKey, $response);
        }
        
        return $response;
    }
    
    private function addResponseErrors(\CMS\API\Response $response)
    {
        $this->addError(sprintf(
            'Invalid Response: HTTP status code %d',
            $response->getStatusCode()
        ));
        
        $responseBody = $response->getBody();
        
        // message from the application
        if (is_string($responseBody)) {
            $this->addError($responseBody);
        }
        
        // messages from the API
        if (is_object($responseBody)) {
            $message     = 'unknow';
            $description = 'no error message.';
            
            if (property_exists($responseBody, 'error') && property_exists($responseBody, 'error_description')) {
                $message     = $responseBody->error;
                $description = $responseBody->error_description;
            }
            
            if (property_exists($responseBody, 'message') && property_exists($responseBody, 'description')) {
                $message     = $responseBody->message;
                $description = $responseBody->description;
            }
            
            $this->addError(sprintf(
                '%s, %s',
                $message,
                $description
            ));
        }
    }
    
    private function getResponseClass($className, \CMS\API\Response $response)
    {
        // initialise the reponse class
        $responseClassName = sprintf(
            '%s\Response\%s',
            __NAMESPACE__,
            $className
        );
        
        if (!class_exists($responseClassName)) {
            throw new \LogicException(sprintf(
                'Invalid response class name "%s"',
                $responseClassName
            ));
        }
        
        $responseClass = new $responseClassName($response);
        
        if (!$responseClass instanceof Response\AbstractResponse) {
            throw new \LogicException('Invalid response class, not an instance of Response\AbstractResponse');
        }
        
        if (!$responseClass->isValid()) {
            $this->addError(sprintf(
                'Invalid Response\%s: %s',
                $className,
                $responseClass->getMessages()
            ));
            return null;
        }
        
        return $responseClass;
    }
    
    private static function isParameterValid($name, $value, array $validValues)
    {
        if (!in_array($value, $validValues)) {
            throw new \LogicException(sprintf(
                'Invalid parameter "%s" with the value "%s"',
                $name,
                $value
            ));
        }
    }
}
