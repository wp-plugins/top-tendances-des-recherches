<?php

namespace Orange\Partner\TopTendance\Cache\Driver;

use Orange\Partner\TopTendance\Plugin;

class Database implements \Orange\Partner\Core\Cache\CacheInterface
{
    const
        TTL = 3600;
    
    const
        KEY_ROW       = 'cache_key',
        VALUE_ROW     = 'cache_value',
        DATE_TIME_ROW = 'cache_date_time';
    
    private static function getWpdb()
    {
        global $wpdb;
        return $wpdb;
    }
    
    private static function getTableName()
    {
        return sprintf(
            '%splugin_%s_cache',
            self::getWpdb()->prefix,
            Plugin::getSlugName()
        );
    }
    
    private static function prepare($data)
    {
        return self::getWpdb()->prepare('%s', $data);
    }
    
    public static function createTable()
    {
        self::getWpdb()->query(sprintf(
            'CREATE TABLE %s (%s VARCHAR(255) PRIMARY KEY, %s TEXT NOT NULL, %s DATETIME NOT NULL);',
            self::getTableName(),
            self::KEY_ROW,
            self::VALUE_ROW,
            self::DATE_TIME_ROW
        ));
    }
    
    public static function deleteTable()
    {
        self::getWpdb()->query(sprintf(
            'DROP TABLE IF EXISTS %s;',
            self::getTableName()
        ));
    }
    
    public function get($key)
    {
        $value = self::getWpdb()->get_var(sprintf(
            "SELECT %s FROM %s WHERE %s = %s",
            self::VALUE_ROW,
            self::getTableName(),
            self::KEY_ROW,
            self::prepare($key)
        ));
        
        if ($value === null) {
            throw new \LogicException(sprintf(
                'Unable to find the cache key "%s"',
                $key
            ));
        }
        
        return unserialize($value);
    }
    
    public function set($key, $value)
    {
        $now = new \DateTime();
        
        $result = self::getWpdb()->replace(self::getTableName(), array(
            self::KEY_ROW       => $key,
            self::VALUE_ROW     => serialize($value),
            self::DATE_TIME_ROW => $now->format('Y-m-d H:i:s'),
        ));
        
        if ($result === false) {
            throw new \LogicException(sprintf(
                'Unable to set the value to the cache key "%s"',
                $key
            ));
        }
    }
    
    public function isValid($key)
    {
        $dateTime = self::getWpdb()->get_var(sprintf(
            "SELECT %s FROM `%s` WHERE %s = %s",
            self::DATE_TIME_ROW,
            self::getTableName(),
            self::KEY_ROW,
            self::prepare($key)
        ));
        
        if ($dateTime === null) {
            return false;
        }
        
        $rowDateTime = new \DateTime($dateTime);
        $rowDateTime
            ->modify(sprintf(
                '+%d seconds',
                $this->getTTL($key)
            ));
        
        if (new \DateTime() > $rowDateTime) {
            return false;
        }
        
        return true;
    }
    
    public function getTTL($key)
    {
        return self::TTL;
    }
}