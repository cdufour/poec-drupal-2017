<?php

namespace Drupal\proverb\Controller;

use Drupal\Core\Controller\ControllerBase;
//use Drupal\Node\Entity\Node;

class ProverbController extends ControllerBase {

  public function list() {

    // retourne un objet modélisant le node id 1
    $node = \Drupal\node\Entity\Node::load(9);

    $title = $node->getTitle();
    // équivalent à:
    $titlebis = $node->title->value;
    // ->title renvoie un objet, ->value renvoie la valeur brut

    $body = $node->body->value;

    return [
      '#markup' => '<h2>' . $title . '</h2>' . $body
    ];
  }

}
