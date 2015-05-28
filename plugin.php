<?php

/*
Plugin Name: TOP TENDANCE DES RECHERCHES
Plugin URI: https://www.orangepartner.com/toptrends-wordpress-plugin
Description: Fournit toutes les heures, le Top des sujets d'actualité les plus recherchés par les Français sur le moteur de recherche d'Orange, les médias et les réseaux sociaux. Ce plugin se décline aussi en un top Personnalités et Sport. Il incite ainsi à s'informer et à lire la presse Française bien mise en avant ensuite.
Version: 1.0.1
Author: Orange Partner
Author URI: http://www.orangepartner.com
License: GPL2
*/

// check compatibility
if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    echo "<p>Une erreur technique empêche le bon fonctionnement de l'extension Top Tendance.
        Veuillez vérifier les versions des logiciels de votre environnement serveur.
        La version de PHP doit être supérieure à <code>5.4</code> et WordPress à <code>4.1</code> pour être compatible avec l'extension.
        </p>";
    
    exit;
}

require __DIR__ . '/vendor/autoload.php';
new \Orange\Partner\TopTendance\Plugin();
