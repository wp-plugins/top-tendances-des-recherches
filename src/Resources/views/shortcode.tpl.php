<?php

use Orange\Partner\TopTendance\Plugin;

?>

<ul class="shortcode_<?php echo Plugin::getSlugName() ?>">
    <?php foreach ($parameters['values'] as $value) { ?>
        <li><a href="<?php echo $value['url']; ?>" target="_blank"><?php echo $value['keywords']; ?></a></li>
    <?php } ?>
</ul>
