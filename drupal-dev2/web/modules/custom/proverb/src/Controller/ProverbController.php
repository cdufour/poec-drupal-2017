<?php

namespace Drupal\proverb\Controller;

use Drupal\Core\Controller\ControllerBase;
//use Drupal\Node\Entity\Node;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

  public function listBannedBis() {

    // récupération des proverbes
    $query = \Drupal::service('entity.query')->get('node');
    $query->condition('type', 'proverb');
    $nids = $query->execute();
    $proverbs = \Drupal\node\Entity\Node::loadMultiple($nids);

    // récupération des mots interdits via service database
    $db = \Drupal::service('database');
    $q = "SELECT * FROM banned_word";
    $words = $db->query($q)->fetchAll();

    $output = '<ul>';
    foreach($proverbs as $proverb) {
      // note: cette boucle imbriquée peut aussi se faire avec foreach
      for($i=0; $i<sizeof($words); $i++) {
        if ($this->isBanned($proverb->getTitle(), $words[$i]->word)) {
          $output .= '<li>' . $proverb->getTitle() . '</li>';
          break;
        }
      }
    }
    $output .= '</ul>';

    return [
      '#markup' => $output
    ];
  }

  public function listBannedWords() {

    //$db = \Drupal::service('database');
    // syntaxe alternative, par raccourci:
    $db = \Drupal::database();

    $results = $db->select('banned_word', 'b')
      ->fields('b')
      ->execute();

    // fetchAll renvoie un tableau d'objects (stdClass)
    $words = $results->fetchAll();

    // Variante 1
    // $output = '<table>';
    // foreach($words as $word) {
    //   $output .= '<tr>';
    //   $output .= '<td>'.$word->word.'</td>';
    //   $output .= '</tr>';
    // }
    // $output .= '</table>';

    // return [
    //   '#markup' => $output
    // ];

    // Variante 2.1: liste
    // $items = [];
    // foreach($words as $word) {
    //   $item = ['#markup' => $word->word];
    //   $items[] = $item;
    // }
    //
    // return [
    //   '#theme' => 'item_list',
    //   '#items' => $items
    // ];

    // Variante 2.2, on utilise le type de rendu 'table'
    // Le système de rendu ira chercher le template table.html.twig
    // pour gérer le balisage html corresponsant
    // Avantages de cette variante:
    //  séparation entre données  et présentation
    //  possiblités d'intervention (hooking) dans le tableau assoc
    // avant le rendu final (réponse au client)

    $rows = [];
    foreach($words as $word) {
      $r = [
        '#data' => $word->word,
        '<a href="#">Supprimer</a>'
      ];
      $rows[] = $r;
    }

    return [
      '#theme' => 'table',
      '#header' => array('Mot', 'Actions'),
      '#rows' => $rows
    ];




  }

  public function bannedWordDelete(Request $request) {

    $word_id = (int) $request->get('id');

    $db = \Drupal::database();
    $result = $db->delete('banned_word')
      ->condition('id', $word_id)
      ->execute();

    return ['#markup' => '...'];
  }
}
