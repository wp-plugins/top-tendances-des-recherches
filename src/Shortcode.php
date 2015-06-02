<?php

namespace Orange\Partner\TopTendance;

use Orange\Partner\Core;

class Shortcode
{
    public function __construct()
    {
        // initialize
        $this->register();
    }
    
    private function register()
    {
        add_shortcode(Plugin::getSlugName(), array($this, 'shortcode'));
    }
    
    public function shortcode($instance)
    {
        // default values
        $defaultInstance = array(
            Plugin::CATEGORY_NAME => Core\API\TopTrends::DEFAULT_CATEGORY,
            Plugin::LIMIT_NAME    => Core\API\TopTrends::DEFAULT_LIMIT,
        );
        
        $instance = shortcode_atts($defaultInstance, $instance);
        
        $responseSearch = Plugin::getCoreAPITopTrendsSearch($instance[Plugin::CATEGORY_NAME], $instance[Plugin::LIMIT_NAME]);
        
        if (!$responseSearch instanceof Core\API\Response\Search) {
            return null;
        }
        
        return $this->getRender('shortcode.tpl.php', array(
            'values' => $responseSearch->getValues(),
        ));
    }
    
    private function getAction($name)
    {
        $actionName = sprintf(
            '%sAction',
            $name
        );
        
        $callable = array($this, $actionName);
        
        if (!is_callable($callable)) {
            throw new \LogicException(sprintf(
                'Unable to find the callable method %s',
                $actionName
            ));
        }
        
        return $callable;
    }
    
    private function getRender($templateName, array $parameters = array())
    {
        ob_start();
        $this->render($templateName, $parameters);
        return ob_get_clean();
    }
    
    private function render($templateName, array $parameters = array())
    {
        require Plugin::getTemplateFilePath($templateName);
    }
}
