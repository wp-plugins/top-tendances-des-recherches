<?php

use Orange\Partner\TopTendance\Plugin;
use Orange\Partner\TopTendance\Option;
use Orange\Partner\Core;

$state = 'Invalid';
if ($parameters['isTokenValid']) {
    $state = 'Valid';
}

?>

<h2><?php echo Plugin::translate('Utilisation :'); ?></h2>
<blockquote>
    <h3><?php echo Plugin::translate('Widget :'); ?></h3>
    <p>
        <?php echo Plugin::translate('Configurez votre widget en allant sur :'); ?> <a href="<?php echo admin_url('widgets.php'); ?>"><?php echo __('Appearance') ?> > <?php echo __('Widgets'); ?></a>
    </p>
    
    <h3><?php echo Plugin::translate('Shortcode :'); ?></h3>
    <p>
        <?php echo Plugin::translate('Utilisez un shortcode avec la syntaxe suivante :'); ?> <code>[<?php echo Plugin::getSlugName(); ?> <?php echo Plugin::CATEGORY_NAME; ?>="<?php echo implode('/', Core\API\TopTrends::getSearchCategories()) ?>" <?php echo Plugin::LIMIT_NAME; ?>=<?php echo implode('/', Core\API\TopTrends::getSearchLimits()) ?>]</code>
    </p>
    <p>
        <?php echo Plugin::translate('Exemples :'); ?>
    </p>
    <ul>
        <li><code>[<?php echo Plugin::getSlugName(); ?>]</code></li>
        <li><code>[<?php echo Plugin::getSlugName(); ?> <?php echo Plugin::CATEGORY_NAME; ?>="<?php echo Core\API\TopTrends::DEFAULT_CATEGORY ?>"]</code></li>
        <li><code>[<?php echo Plugin::getSlugName(); ?> <?php echo Plugin::LIMIT_NAME; ?>=<?php echo Core\API\TopTrends::DEFAULT_LIMIT ?>]</code></li>
        <li><code>[<?php echo Plugin::getSlugName(); ?> <?php echo Plugin::CATEGORY_NAME; ?>="<?php echo Core\API\TopTrends::DEFAULT_CATEGORY ?>" <?php echo Plugin::LIMIT_NAME; ?>=<?php echo Core\API\TopTrends::DEFAULT_LIMIT ?>]</code></li>
    </ul>
</blockquote>

<hr />

<h2><?php echo Plugin::translate('Configuration :'); ?></h2>
<blockquote>
    <h3><?php echo Plugin::translate('Identifiants :'); ?></h3>
    <ul>
        <li><label><?php echo Plugin::translate('Client ID'); ?></label> :     <code><?php echo Option::getClientId(); ?></code></li>
        <li><label><?php echo Plugin::translate('Client Secret'); ?></label> : <code><?php echo Option::getClientSecret(); ?></code></li>
    </ul>
    
    <h3><?php echo Plugin::translate('Validité :'); ?></h3>
    <ul>
        <li><label><?php echo Plugin::translate('Token'); ?></label> : <code><?php echo Option::getTokenValue(); ?></code></li>
        <li><label><?php echo Plugin::translate('Etat du token'); ?></label> : <span class="token-state <?php echo strtolower($state); ?>-token"><?php echo Plugin::translate($state); ?></span></li>
    </ul>
</blockquote>
