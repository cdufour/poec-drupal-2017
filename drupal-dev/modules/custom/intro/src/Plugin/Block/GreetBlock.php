<?php

namespace Drupal\intro\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * @Block(
 *  id = "intro_greet_block",
 *  admin_label = "Greeting Block"
 * )
 *
 */
class GreetBlock extends BlockBase {
  public function __construct() {}

  public function build() {
    // la méthode config n'est pas disponible pour un block
    //$config = $this->config('intro.custom_greeting');

    // getConfiguration renvoie un tableau associatif représentant
    // la configuration du block courant
    // Ne permet d'accèder à la table Config de la base de données
    // $config = $this->getConfiguration();

    // les Plugins ont nativement accès à moins de méthodes Helpers
    // Objectif: récupérer des infos depuis la table Config

    // $messenger = new \Drupal\intro\Messenger();
    // return [
    //   '#markup' => $messenger->getMessageBis()
    // ];

    /*
    Le code suivant permet de charger une classe
    par l'intermédiaire du DIC (Dependency Injection Container)
    */

    // $container = \Drupal::getContainer();
    // $messenger = $container->get('intro.messenger');

    // syntaxe alternative permettant de récupérer directement
    // le service demandé
    $messenger = \Drupal::service('intro.messengerbis');
    return [
      '#markup' => $messenger->getMessage()
    ];

  }

}
