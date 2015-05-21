=== Plugin Name ===
Tags: api, category, filter, news, search, shortcode, social media, twitter, widget, sports
Stable tag: 1.0
Requires at least: 4.1
Tested up to: 4.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Top des sujets d'actualité les plus recherchés par les Français sur le moteur de recherche d'Orange, les médias et les réseaux sociaux.

== Description ==

Fournit toutes les heures, le Top des sujets d'actualité les plus recherchés par les Français sur le moteur de recherche d'Orange, les médias et les réseaux sociaux.
 
Ce plugin se décline aussi en un top Personnalités et Sport. 

Il incite ainsi à s'informer et à lire la presse Française bien mise en avant ensuite.

== Installation ==

1. Installez le plugin via le WordPress.org plugin directory, ou en uploadant les fichiers sur votre serveur.
2. Activez le plugin depuis le menu de WordPress.
3. Mettez en place, à votre convenance, un Widget ou un Shortcode `[top_tendance]`.

== Frequently Asked Questions ==

**1) FAQ sur l'affichage des réponses**

= Je ne sais pas comment utiliser le plugin dans ma page =
Vous avez deux moyens,

 * soit par le backoffice WordPress, en allant dans Apparence > Widgets, puis en déplaçant le widget intitulé « Top tendance » dans la colonne appropriée.
 * soit directement dans votre page, en utilisant la notation « shortcode ».
   * Exemple 1 (n'afficher que l'actu, 5 réponses au maximum) : ``[top_tendance category="actu" limit=5]`` 
   * Exemple 2 (afficher toutes les catégories d'articles, 5 réponses au maximum) : ``[top_tendance limit=5]``

= La limite de mon plugin est paramétrée à 15, pourtant, en front, le plugin n'affiche que 12 articles =
Effectivement, il peut y avoir moins d'articles que la limite donnée. Ex : 13 articles retournés par l'API alors que la limite donnée est 15.

= Un article sport dans le flux actualité ne se retrouve pas forcément dans le flux Sport. Idem pour les autres... =
Chaque catégorie de flux est totalement indépendante. Les articles des différentes catégories peuvent quelques fois se recouper mais ce n'est pas le fonctionnement nominal du widget.

= Je souhaite appliquer un style particulier ou celui du thème de mon site au shortcode top_tendance =
Le plugin n'intègre pas de feuille de style particulière mais il est construit de manière à interfacer aisément le style du thème au plugin.

Exemple : dans la feuille de style du thème, il est possible de personnaliser le style du shortcode de la manière suivante :

 * Exemple 1 : ``div.entry-content ul.shortcode_top_tendance {border: 1px dashed #000;}``
 * Exemple 2 : ``div.entry-content ul.shortcode_top_tendance li a {color: inherit;}``

= Le top tendance change régulièrement dans la journée et des fois rarement =
C'est normal, le top tendance suit l'actualité du moment, parfois avec des changements toutes les heures (plusieurs événements dans la journée), parfois sur une journée (sujet qui reste avec un buzz fort).

= J'ai peur d'avoir des top tendances à caractère pornographique, raciste ou violent parfois =
Notre top tendance dispose de mécanismes de protection afin d'éviter d'afficher des mots choquants pour le grand public ou de renvoyer vers des articles destinés à un public averti.

= J'ai installé le top tendance, et des fois les réponses sont surprenantes (sujets peu importants, mots inconnus, etc.) =
Le top tendance est construit sur des gros volumes de recherches, il correspond donc à des demandes massives réelles qui peuvent faire partie d'un buzz du moment, d'une tendance. Vous n'avez pas fini d'apprendre des choses avec le top tendance !

**2) FAQ technique**

= Des erreurs s'affichent à l'utilisation du plugin =
Vérifiez les versions des logiciels de votre environnement serveur. PHP doit être supérieur à 5.4 et WordPress doit être supérieur à 4.1 pour être compatible avec le plugin.

= Dans la page du backoffice WordPress de configuration du plugin, j'ai un message d'erreur « La génération du token a échoué » =
Vérifiez que vous n'avez pas de règles de filtrage sur votre configuration réseau (firewall, routeur, etc.).

= D'habitude, j'ai des réponses affichées dans mon bloc top tendance, mais aujourd'hui rien =
Il se peut que les réponses du top tendance ne soit pas disponibles à cause d'un incident technique de notre côté. De ce fait, votre top tendance devient vide. Vous n'avez rien à faire, juste attendre le retour du service.

= Comment être informé des mises-à-jour du plugin =
Si vous avez installé le plugin de façon standard, comme un plugin WordPress traditionnel, vous n'avez rien à faire, la mise-à-jour sera automatique. Vous pourrez ainsi bénéficier de nouvelles catégories et options.

= Mon hébergeur me facture la bande passante consommée. Le plugin top tendance est-il gourmand en volume de données transférées ? =
Non. Il est optimisé pour limiter le nombre de requêtes effectuées en sortie de votre serveur. De plus, les réponses, de type texte, sont de très petite taille.


== Screenshots ==

1. Réglages de l'extension

== Changelog ==

= 1.0 =
* Livraison initiale