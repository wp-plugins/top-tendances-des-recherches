<?php

namespace Orange\Partner\Core\API\Response;

class Token extends AbstractResponse
{
    const
        TOKEN_VALUE      = 'access_token',
        TOKEN_EXPIRES_IN = 'expires_in',
        TOKEN_TYPE       = 'token_type';
    
    const
        TOKEN_TYPE_VALUE = 'Bearer';
    
    public function getValue()
    {
        return $this->getProperty(self::TOKEN_VALUE);
    }
    
    public function getDateTime()
    {
        $dateTime = clone $this->responseDateTime;
        $dateTime->add(new \DateInterval(sprintf(
            'PT%dS',
            $this->getProperty(self::TOKEN_EXPIRES_IN)
        )));
        
        return $dateTime;
    }
    
    protected function getProperties()
    {
        return array(
            self::TOKEN_VALUE,
            self::TOKEN_EXPIRES_IN,
            self::TOKEN_TYPE,
        );
    }
    
    protected function getPropertiesType()
    {
        return array(
            self::TOKEN_VALUE      => 'string',
            self::TOKEN_EXPIRES_IN => 'string',
            self::TOKEN_TYPE       => 'string',
        );
    }
    
    protected function getPropertiesData()
    {
        return array(
            self::TOKEN_TYPE => self::TOKEN_TYPE_VALUE,
        );
    }
}
