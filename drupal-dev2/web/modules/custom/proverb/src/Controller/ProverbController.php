<?php

namespace Drupal\proverb\Controller;

use Drupal\Core\Controller\ControllerBase;
//use Drupal\Node\Entity\Node;

class ProverbController extends ControllerBase {

  private $forbidden_word;

  public function __construct() {
    $this->forbidden_word = 'Paul';
  }

  private function isBanned($title, $forbidden_word) {
    if (strstr(strtolower($title), strtolower($forbidden_word)) != false) {
      // le mot interdit a été trouvé
      return true;
    } else {
      // le mot interdit n'a pas été trouvé
      return false;
    }
  }

  public function list() {

    // retourne un objet modélisant le node id 1
    //$node = \Drupal\node\Entity\Node::load(1);
    //$title = $node->getTitle();
    // équivalent à:
    //$titlebis = $node->title->value;
    // ->title renvoie un objet, ->value renvoie la valeur brut
    //$body = $node->body->value;
    //dpm($body);

    // utilisation d'un service d'interrogation de la base de données
    // (limité aux entités: node, user, term, ...)
    $query = \Drupal::service('entity.query')->get('node');

    // construction d'une requête avec condition/filtre
    $query->condition('type', 'proverb');

    // $nids reçoit un tableau d'identifiants (des entiers)
    $nids = $query->execute();

    // $proverbs reçoit un tableau d'objets de type NodeInterface
    $proverbs = \Drupal\node\Entity\Node::loadMultiple($nids);

    // sortie client
    $output = '<ul>';
    foreach($proverbs as $proverb) {
      //dpm($proverb->getTitle());
      if (!$this->isBanned($proverb->getTitle(), $this->forbidden_word)) {
        $output .= '<li>'. $proverb->getTitle() .'</li>';
      }

    }
    $output .= '</ul>';

    // Interrogation des Users *******************
    $query2 = \Drupal::service('entity.query')->get('user');
    $query2->condition('status', 1); // filtre => on cible les actifs
    $uids = $query2->execute();
    $users = \Drupal\user\Entity\User::loadMultiple($uids);
    foreach($users as $user) {
      //dpm($user->getUsername());
      if ($user->isActive() == 1) {
        //dpm('Actif');
      } else {
        //dpm('Bloqué');
      }
      //dpm($user->getRoles());
      if ($user->hasRole('administrator')) {
        //dpm('Je suis admin');
      }
    }
    //********************************************

    return [
      '#markup' => $output
    ];
  }

  public function listBanned() {

    $query = \Drupal::service('entity.query')->get('node');
    $query->condition('type', 'proverb');
    $nids = $query->execute();
    $proverbs = \Drupal\node\Entity\Node::loadMultiple($nids);

    $output = '<ul>';
    foreach($proverbs as $proverb) {
      if ($this->isBanned($proverb->getTitle(), $this->forbidden_word)) {
        $output .= '<li>' . $proverb->getTitle() . '</li>';
      }
    }
    $output .= '</ul>';

    return [
      '#markup' => $output
    ];
  }

}
