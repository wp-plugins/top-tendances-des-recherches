<?php

namespace Orange\Partner\Core\API\Response;

class Search extends AbstractResponse
{
    const
        // root property values
        SEARCH_VALUES = 'toptrends';
    
    const
        // properties of each element of the root property values
        SEARCH_VALUE_KEYWORDS = 'keywords',
        SEARCH_VALUE_URL      = 'searchLink',
        SEARCH_VALUE_IMAGE    = 'image';
    
    private static
        // element keys used to create returned values
        $elementKeywordsKey = 'keywords',
        $elementUrlKey      = 'url',
        $elementImageKey    = 'image';
    
    public function getValues()
    {
        $values = array();
        
        foreach ($this->getProperty(self::SEARCH_VALUES) as $value) {
            $values[] = array(
                self::$elementKeywordsKey => $this->getPropertyOfOneValueElement(self::SEARCH_VALUE_KEYWORDS, $value),
                self::$elementUrlKey      => $this->getPropertyOfOneValueElement(self::SEARCH_VALUE_URL, $value),
                self::$elementImageKey    => $this->getOptionalPropertyOfOneValueElement(self::SEARCH_VALUE_IMAGE, $value, null),
            );
        }
        
        return $values;
    }
    
    public function isValid()
    {
        if (!parent::isValid()) {
            return false;
        }
        
        if (!$this->isValidValues()) {
            return false;
        }
        
        return true;
    }
    
    protected function getProperties()
    {
        return array(
            self::SEARCH_VALUES,
        );
    }
    
    protected function getPropertiesType()
    {
        return array(
            self::SEARCH_VALUES => 'array',
        );
    }
    
    protected function getPropertiesData()
    {
        return array(
        );
    }
    
    private function isValidValues()
    {
        $valid = true;
        
        foreach ($this->getProperty(self::SEARCH_VALUES) as $key => $value) {
            foreach ($this->getEachElementPropertiesOfPropertyValues() as $property) {
                if (!property_exists($value, $property)) {
                    $this->messages[] = sprintf(
                        'Unable to find the required property "%s" on the #%d value element',
                        $property,
                        $key
                    );
                    
                    $valid = false;
                }
            }
        }
        
        return $valid;
    }
    
    protected function getEachElementPropertiesOfPropertyValues()
    {
        return array(
            self::SEARCH_VALUE_KEYWORDS,
            self::SEARCH_VALUE_URL,
        );
    }
    
    protected function getPropertyOfOneValueElement($property, $value)
    {
        if (!property_exists($value, $property)) {
            throw new \LogicException(sprintf(
                'Unable to get the property "%s" on one value element',
                $property
            ));
        }
        
        return $value->$property;
    }
    
    protected function getOptionalPropertyOfOneValueElement($property, $value, $default)
    {
        if (!property_exists($value, $property)) {
            return $default;
        }
        
        return $this->getPropertyOfOneValueElement($property, $value);
    }
}
