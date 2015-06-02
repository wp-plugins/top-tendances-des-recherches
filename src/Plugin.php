<?php

namespace Orange\Partner\TopTendance;

use Orange\Partner\Core;

class Plugin
{
    const
        NAME        = 'Top Tendance des recherches',
        SHORT_NAME  = 'Top Tendance',
        DESCRIPTION = "Fournit le Top des sujets d'actualité les plus recherchés par les Français sur le moteur de recherche d'Orange, les médias et les réseaux sociaux.";
    
    const
        CATEGORY_NAME = 'category',
        LIMIT_NAME    = 'limit';
    
    private static
        $coreAPITopTrends;
    
    public function __construct()
    {
        // initialize
        $this->loadPluginLanguages();
        $this->loadDashboard();
        $this->loadWidget();
        $this->loadShortcode();
    }
    
    public static function translate($sentence)
    {
        return __($sentence, self::getSlugName());
    }
    
    public static function getSlugName()
    {
        return preg_replace('~[^a-z]~', '_', strtolower(self::SHORT_NAME));
    }
    
    public static function getName()
    {
        return self::translate(self::NAME);
    }
    
    public static function getShortName()
    {
        return self::translate(self::SHORT_NAME);
    }
    
    public static function getDescription()
    {
        return self::translate(self::DESCRIPTION);
    }
    
    public static function getPluginDirectory()
    {
        return realpath(sprintf(
            '%s/..',
            __DIR__
        ));
    }
    
    public static function getPluginPHPFile()
    {
        return sprintf(
            '%s/plugin.php',
            self::getPluginDirectory()
        );
    }
    
    public static function getLanguagesDirectory()
    {
        return sprintf(
            '%s/languages',
            self::getPluginDirectory()
        );
    }
    
    public static function getTemplateFilePath($filePath)
    {
        return self::getResourceFilePath('views', $filePath);
    }
    
    public static function getPublicFileUrl($filePath)
    {
        return self::getResourceFilePath('public', $filePath, true);
    }
    
    /**
     * Singleton Pattern
     *
     * @return \Orange\Partner\Core\API\TopTrends
     */
    public static function getCoreAPITopTrends()
    {
        if (!self::$coreAPITopTrends instanceof Core\API\TopTrends) {
            // initialize
            self::$coreAPITopTrends = new Core\API\TopTrends();
            self::$coreAPITopTrends
                ->enableCaching()
                ->setCacheDriver(new Cache\Driver\Database());
        }
        
        return self::$coreAPITopTrends;
    }
    
    public static function getCoreAPITopTrendsSearch($category, $limit)
    {
        if (!Core\API\TopTrends::isTokenValid(Option::getTokenDateTime())) {
            $responseToken = self::getCoreAPITopTrendsAuthorizationToken();
            
            if (!$responseToken instanceof Core\API\Response\Token) {
                return null;
            }
            
            Option::updateToken($responseToken->getValue(), $responseToken->getDateTime());
        }
        
        try {
            return self::getCoreAPITopTrends()->getSearch(Option::getTokenValue(), $category, $limit);
        } catch (\LogicException $exception) {
            // return the default search if parameters are invalids
            return self::getCoreAPITopTrends()->getSearch(Option::getTokenValue());
        }
    }
    
    public static function getCoreAPITopTrendsAuthorizationToken()
    {
        return self::getCoreAPITopTrends()->getAuthorizationToken(base64_encode(sprintf(
            '%s:%s',
            Option::getClientId(),
            Option::getClientSecret()
        )));
    }
    
    private function loadPluginLanguages()
    {
        load_plugin_textdomain(self::getSlugName(), false, self::getLanguagesDirectory());
    }
    
    private function loadDashboard()
    {
        if (is_admin()) {
            new Dashboard\Setting();
        }
    }
    
    private function loadWidget()
    {
        new Widget();
    }
    
    private function loadShortcode()
    {
        new Shortcode();
    }
    
    private static function getResourceFilePath($resourcesType, $filePath, $pluginPath = false)
    {
        $resourceFilePath = sprintf(
            'src/Resources/%s/%s',
            $resourcesType,
            $filePath
        );
        
        // absolute path
        $absoluteFilePathOfResource = sprintf(
            '%s/%s',
            self::getPluginDirectory(),
            $resourceFilePath
        );
        
        if (!is_file($absoluteFilePathOfResource)) {
            throw new \LogicException(sprintf(
                'Unable to find the resource file %s',
                $absoluteFilePathOfResource
            ));
        }
        
        if ($pluginPath === true) {
            return $resourceFilePath;
        }
        
        return $absoluteFilePathOfResource;
    }
}
