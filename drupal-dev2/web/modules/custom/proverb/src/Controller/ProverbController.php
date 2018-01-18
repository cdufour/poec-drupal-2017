<?php

namespace Drupal\proverb\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Drupal\Core\Url;

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

      // from Route renvoie un objet de type Url
      $url = Url::fromRoute(
        'proverb.banned_word_delete',
        array('id' => $word->id)
      );

      // le service l générè un lien à partir d'un objet Url
      $link = \Drupal::l('Supprimer', $url);

      $r = [$word->word, $link];
      $rows[] = $r;
    }

    // N.B: ici, on transmets la tableau assoc au template
    // table.html.twig qui ne reconnaît pas la clé #markup.
    // TODO étendre le template afin qu'il traite les clés
    // supplémentaires
    return [
      '#markup' => 'fsdfsdfsd',
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

    if ($result != 1) {
      // aucune suppression
      return ['#markup' => 'La suppression a échoué. Désolé...'];
    } else {
      // suppresion réussie: redirection vers le tableau des mots bannis
      return $this->redirect('proverb.banned_words');
    }

  }

  public function listByCategory(Request $request) {

    // récupération de la valeur de l'argument Url category
    $category = $request->get('category');

    // 1 récupération des identifiants de node (nids)
    $query = \Drupal::service('entity.query')->get('node');
    $query->condition('type', 'proverb');
    $query->condition('field_category', $category);
    // égal à:
    //$query->condition('field_category.value', $category);
    $nids = $query->execute();

    // 2 chargement
    $proverbs = Node::loadMultiple($nids);

    // 3 parcours des données et création de la variable $items
    // qu'on fournira ensuite au template item_list
    $items = [];
    foreach($proverbs as $proverb) {
      $items[] = $proverb->getTitle();
    }

    return [
      '#theme' => 'item_list',
      '#items' => $items
    ];
  }

  public function test() {
    // On courcircuite le système de rendu Drupal
    // Aucun template n'est rendu dans la réponse client
    // return new Response('Exemple: renvoyer données au format JSON...');

    $out = [];

    $out['cb'] = array(
      '#type' => 'checkbox',
      '#title' => 'CB'
    );

    $out['cb2'] = array(
      '#type' => 'checkbox',
      '#title' => 'CB2'
    );

    $out['select'] = array(
      '#type' => 'select',
      '#title' => 'Select',
      '#options' => array('Option1', 'Option2')
    );

    $out['free'] = array(
      '#markup' => '<p>Balisage libre</p>'
    );

    $out['list'] = array(
      '#theme' => 'item_list',
      '#items' => array('Item 1', 'Item 2', 'Item 3')
    );

    $roles = \Drupal::currentUser()->getRoles();
    $out['list_perso'] = array(
      '#theme' => 'list',
      '#items' => ['Pomme', 'Poire', 'Cerise'],
      '#isUserAdmin' => in_array('administrator', $roles)
    );

    return $out;
  }

  public function listJson() {
    // charger les proverbes et les convertir en JSON
    $nids = \Drupal::entityQuery('node')
      ->condition('type', 'proverb')
      ->execute();

    $proverbs = Node::loadMultiple($nids);

    $res = [];
    foreach($proverbs as $proverb) {
      $res[] = [
        'title' => $proverb->get('title')->value,
        'category' => $proverb->get('field_category')->value
      ];
    }

    $res_json = json_encode($res);
    return new Response($res_json);
  }

}
