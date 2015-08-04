<?php

use Orange\Partner\TopTendance\Plugin;
use Orange\Partner\TopTendance\Option;
use Orange\Partner\Core;

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

