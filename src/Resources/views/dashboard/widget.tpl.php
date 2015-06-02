<?php

use Orange\Partner\TopTendance\Plugin;

?>

<p>
    <label for="<?php echo $parameters['title']['fieldName']; ?>">
        <?php echo Plugin::translate('Titre :'); ?>
    </label>
    <input class="widefat" id="<?php echo $parameters['title']['fieldId']; ?>" name="<?php echo $parameters['title']['fieldName']; ?>" type="text" value="<?php echo $parameters['title']['value']; ?>" />
</p>

<p>
    <label for="<?php echo $parameters[Plugin::CATEGORY_NAME]['fieldName']; ?>">
        <?php echo Plugin::translate('Catégorie :'); ?>
    </label>
    <select id="<?php echo $parameters[Plugin::CATEGORY_NAME]['fieldId']; ?>" name="<?php echo $parameters[Plugin::CATEGORY_NAME]['fieldName']; ?>">
        <?php foreach ($parameters[Plugin::CATEGORY_NAME]['options'] as $value => $name) {
            $selected = '';
            if ($value === $parameters[Plugin::CATEGORY_NAME]['value']) {
                $selected = 'selected="selected"';
            } ?>
            <option value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo Plugin::translate($name); ?></option>
        <?php } ?>
    </select>
</p>

<p>
    <label for="<?php echo $parameters[Plugin::LIMIT_NAME]['fieldName']; ?>">
        <?php echo Plugin::translate('Nombre de mots à afficher :'); ?>
    </label>
    <select id="<?php echo $parameters[Plugin::LIMIT_NAME]['fieldId']; ?>" name="<?php echo $parameters[Plugin::LIMIT_NAME]['fieldName']; ?>">
        <?php foreach ($parameters[Plugin::LIMIT_NAME]['options'] as $value => $name) {
            $selected = '';
            if ($value === (int) $parameters[Plugin::LIMIT_NAME]['value']) {
                $selected = 'selected="selected"';
            } ?>
            <option value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo Plugin::translate($name); ?></option>
        <?php } ?>
    </select>
</p>
