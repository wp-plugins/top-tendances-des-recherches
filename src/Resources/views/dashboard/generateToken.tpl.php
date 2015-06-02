<?php

use Orange\Partner\TopTendance\Dashboard;
use Orange\Partner\TopTendance\Plugin;

?>

<h2><?php echo Plugin::translate('Félicitations :'); ?></h2>
<p>
    <span class="generate-token-status successful-message">
        <?php echo Plugin::translate('Le token a bien été généré.'); ?>
    </span>
</p>
<p>
    <a href="<?php echo Dashboard\Setting::getUrl(); ?>"><?php echo Plugin::translate('Revenir à la page précédente'); ?></a>
</p>
