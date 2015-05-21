<?php

namespace Orange\Partner\TopTendance;

use Orange\Partner\Core;

class Widget extends \WP_Widget
{
    public function __construct()
    {
        // initialize
        $this->register();
    }
    
    private function register()
    {
        parent::__construct(Plugin::getSlugName(), Plugin::getShortName(), array(
            'description' => Plugin::getDescription(),
        ));
        
        add_action('widgets_init', function ()
        {
            register_widget(get_class());
        });
    }
    
    
    public function widget($args, $instance)
    {
        $responseSearch = Plugin::getCoreAPITopTrendsSearch($instance[Plugin::CATEGORY_NAME], $instance[Plugin::LIMIT_NAME]);
        
        if (!$responseSearch instanceof Core\API\Response\Search) {
            return null;
        }
        
        $this->render('widget.tpl.php', array(
            'title'  => $instance['title'],
            'values' => $responseSearch->getValues(),
            'args'   => $args,
        ));
    }
    
    private function render($templateName, array $parameters = array())
    {
        require Plugin::getTemplateFilePath($templateName);
    }
    
    public function form($instance)
    {
        // initialize values
        if (empty($instance)) {
            $instance['title']    = Plugin::getName();
            $instance[Plugin::CATEGORY_NAME] = Core\API\TopTrends::DEFAULT_CATEGORY;
            $instance[Plugin::LIMIT_NAME]    = Core\API\TopTrends::DEFAULT_LIMIT;
        }
        
        // initlialize options
        $categories = array_combine(Core\API\TopTrends::getSearchCategories(), array('Actualité', 'Sport', 'Personnalités'));
        $limits     = array_combine(Core\API\TopTrends::getSearchLimits(), Core\API\TopTrends::getSearchLimits());
        
        $this->render('dashboard/widget.tpl.php', array(
            'title'    => $this->getFieldData($instance, 'title'),
            Plugin::CATEGORY_NAME => $this->getFieldData($instance, Plugin::CATEGORY_NAME, $categories),
            Plugin::LIMIT_NAME => $this->getFieldData($instance, Plugin::LIMIT_NAME, $limits),
        ));
    }
    
    private function getFieldData($instance, $name, array $options = array())
    {
        return array(
            'value'     => $instance[$name],
            'fieldId'   => $this->get_field_id($name),
            'fieldName' => $this->get_field_name($name),
            'options'   => $options,
        );
    }
}
