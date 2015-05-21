<?php

use Orange\Partner\TopTendance\Plugin;

echo $parameters['args']['before_widget'];

if (!empty($parameters['title'])) {
    echo $parameters['args']['before_title'] . apply_filters('widget_title', $parameters['title']) . $parameters['args']['after_title'];
}

?>

<ul class="widget_<?php echo Plugin::getSlugName() ?>">
    <?php foreach ($parameters['values'] as $value) { ?>
        <li><a href="<?php echo $value['url']; ?>" target="_blank"><?php echo $value['keywords']; ?></a></li>
    <?php } ?>
</ul>

<?php

echo $parameters['args']['after_widget'];

?>
