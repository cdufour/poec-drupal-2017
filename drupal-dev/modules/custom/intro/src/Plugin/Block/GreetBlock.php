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

  public function build() {
    // la méthode config n'est pas disponible pour un block
    //$config = $this->config('intro.custom_greeting');

    // getConfiguration renvoie un tableau associatif représentant
    // la configuration du block courant
    // Ne permet d'accèder à la table Config de la base de données
    //$config = $this->getConfiguration();

    return [
      '#markup' => 'Blablabla'
    ];
  }

}
