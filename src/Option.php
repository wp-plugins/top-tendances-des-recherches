<?php

namespace Orange\Partner\TopTendance;

class Option
{
    const
        CLIENT_ID      = 'client_id',
        CLIENT_SECRET  = 'client_secret',
        TOKEN_VALUE    = 'token_value',
        TOKEN_DATETIME = 'token_datetime';
    
    const
        CLIENT_ID_DEFAULT_VALUE     = '1fAxa1GSq8CQm9qWqq5sy9a3YMq4xXnY',
        CLIENT_SECRET_DEFAULT_VALUE = '36qqQGb2gBWBi7cF';
    
    public static function getClientId()
    {
        return get_option(self::getRealOptionName(self::CLIENT_ID));
    }
    
    public static function getClientSecret()
    {
        return get_option(self::getRealOptionName(self::CLIENT_SECRET));
    }
    
    public static function getTokenValue()
    {
        return get_option(self::getRealOptionName(self::TOKEN_VALUE));
    }
    
    public static function getTokenDateTime()
    {
        return get_option(self::getRealOptionName(self::TOKEN_DATETIME));
    }
    
    public static function updateOptions()
    {
        $options = array(
            self::CLIENT_ID      => self::CLIENT_ID_DEFAULT_VALUE,
            self::CLIENT_SECRET  => self::CLIENT_SECRET_DEFAULT_VALUE,
            self::TOKEN_VALUE    => null,
            self::TOKEN_DATETIME => new \DateTime('2015-03-09'),
        );
        
        foreach ($options as $option => $value) {
            update_option(self::getRealOptionName($option), $value);
        }
    }
    
    public static function updateToken($value, \DateTime $dateTime)
    {
        // update the token details
        update_option(self::getRealOptionName(self::TOKEN_VALUE), $value);
        update_option(self::getRealOptionName(self::TOKEN_DATETIME), $dateTime);
    }
    
    private static function getRealOptionName($optionName)
    {
        return sprintf(
            '%s_%s',
            Plugin::getSlugName(),
            $optionName
        );
    }
}
