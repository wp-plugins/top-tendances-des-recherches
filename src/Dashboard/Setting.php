<?php

namespace Orange\Partner\TopTendance\Dashboard;

use Orange\Partner\TopTendance\Plugin;
use Orange\Partner\TopTendance\Option;
use Orange\Partner\TopTendance\Cache;
use Orange\Partner\Core;

class Setting
{
    const
        QUERY_STRING_ACTION = 'plugin-page-action';
    
    public function __construct()
    {
        // initialize
        $this->addAdminMenu();
        $this->addAdminStyles();
        $this->addParameterLinkOnExtensionPage();
        $this->registerData();
    }
    
    public function mainAction()
    {
        $this->render('main.tpl.php', array(
            'isTokenValid' => Core\API\TopTrends::isTokenValid(Option::getTokenDateTime()),
        ));
    }
    
    public function generateTokenAction()
    {
        $responseToken = Plugin::getCoreAPITopTrendsAuthorizationToken();
        
        if (!$responseToken instanceof Core\API\Response\Token) {
            $this->render('generateTokenFailed.tpl.php', array(
                'errors' => Plugin::getCoreAPITopTrends()->getErrors(),
            ));
            exit;
        }
        
        Option::updateToken($responseToken->getValue(), $responseToken->getDateTime());
        
        $this->render('generateToken.tpl.php');
    }
    
    public static function getUrl($action = null)
    {
        $actionQuery = '';
        if ($action !== null) {
            $actionQuery = sprintf(
                '&%s=%s',
                self::QUERY_STRING_ACTION,
                $action
            );
        }
        
        return admin_url(sprintf(
            'options-general.php?page=%s%s',
            Plugin::getSlugName(),
            $actionQuery
        ));
    }
    
    private function addAdminMenu()
    {
        add_action('admin_menu', function ()
        {
            add_options_page(Plugin::getName(), Plugin::getShortName(), 'manage_options', Plugin::getSlugName(), $this->getAction('main'));
        });
    }
    
    private function addAdminStyles()
    {
        add_action('admin_head', function ()
        {
            printf(
                '<link href="%s" rel="stylesheet" media="all" type="text/css" />',
                plugins_url(Plugin::getPublicFileUrl('css/dashboard.css'), Plugin::getPluginPHPFile())
            );
        });
    }
    
    private function addParameterLinkOnExtensionPage()
    {
        add_action('plugin_action_links_' . plugin_basename(Plugin::getPluginPHPFile()), function ($links)
        {
            $parameterLink = sprintf(
                '<a href="%s">%s</a>',
                self::getUrl(),
                __('Settings')
            );
            
            array_unshift($links, $parameterLink);
            return $links;
        });
    }
    
    private function registerData()
    {
        register_activation_hook(Plugin::getPluginPHPFile(), function ()
        {
            // register options in the database
            Option::updateOptions();
            
            // create the database table
            Cache\Driver\Database::createTable();
        });
        
        register_deactivation_hook(Plugin::getPluginPHPFile(), function ()
        {
            // delete the database table
            Cache\Driver\Database::deleteTable();
        });
    }
    
    private function getAction($defaultName)
    {
        $name = $defaultName;
        
        // switch to other actions
        if (!empty($_GET[self::QUERY_STRING_ACTION])) {
            $name = $_GET[self::QUERY_STRING_ACTION];
        }
        
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
    
    private function render($templateName, array $parameters = array())
    {
        require Plugin::getTemplateFilePath('dashboard/_header.tpl.php');
        
        require Plugin::getTemplateFilePath(sprintf(
            'dashboard/%s',
            $templateName
        ));
        
        require Plugin::getTemplateFilePath('dashboard/_footer.tpl.php');
    }
}
