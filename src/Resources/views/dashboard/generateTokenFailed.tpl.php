<?php

use Orange\Partner\TopTendance\Dashboard;
use Orange\Partner\TopTendance\Plugin;

?>

<h2><?php echo Plugin::translate('Avertissement :'); ?></h2>
<p>
    <span class="generate-token-status failed-message">
        <?php echo Plugin::translate('La génération du token a échoué.'); ?>
    </span>
</p>
<p>
    <?php echo Plugin::translate('Veuillez vérifier la configuration de votre WordPress et faites un nouvel essai.'); ?>
</p>

<p>
    <a href="<?php echo Dashboard\Setting::getUrl(); ?>"><?php echo Plugin::translate('Revenir à la page précédente'); ?></a>
</p>

<h2><?php echo Plugin::translate("Messages d'erreur :"); ?></h2>
<ul>
    <?php foreach ($parameters['errors'] as $error) { ?>
        <li><?php echo $error; ?></li>
    <?php } ?>
</ul>
