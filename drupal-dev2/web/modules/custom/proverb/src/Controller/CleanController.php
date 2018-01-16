<?php
namespace Drupal\proverb\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

class CleanController extends ControllerBase {

  private function checkQuotes($str) {
    $checked_char = "\"";
    $lastPosition = strlen($str) - 2;
    $firstChar = substr($str, 0, 1);
    $lastChar = substr($str, $lastPosition, 1);

    dpm([$firstChar, $lastChar]);
    return
      $firstChar === $checked_char &&
      $lastChar === $checked_char;
  }

  private function noQuotes($str) {
    $lastPosition = strlen($str) - 2;
    return substr($str, 1, $lastPosition);
  }

  private function checkQuotes2($str) {
    $new_str = "";

    // on se débarrasse de l'éventuel saut de ligne
    if (ord(substr($str, -1)) == 13) {
      $new_str = substr($str, 0, strlen($str)-1);
    } else {
      $new_str = $str;
    }

    // TO DO: prendre en compte la présence
    // éventuelle d'un caractère de fin de ligne (13)
    // en fin de chaîne

    $checked_char = "\"";

    $firstChar = substr($str, 0, 1);
    $lastChar = substr($str, -1);

    if ($firstChar == $checked_char) {
      //dpm("premier caractère = guillemet");

      // nouvelle chaîne sans le guillement initial
      $new_str = substr($new_str, 1);

      $lastChar = substr($new_str, -1);

      if ($lastChar == $checked_char) {
        //dpm("dernier caractère = guillemet");
        $new_str = substr($new_str, 0, strlen($new_str)-1);
      }

    } else {

      if ($lastChar == $checked_char) {
        //dpm("dernier caractère = guillemet");
        $new_str = substr($new_str, 0, strlen($new_str)-1);
      }
    }

    return $new_str;
  }

  public function removeQuotes() {

    // 1. récupération des id de Proverbes
    $query =  \Drupal::entityQuery('node');
    $query->condition('type', 'proverb');
    $nids = $query->execute();

    //2. charger les entités
    $proverbs = Node::loadMultiple($nids);

    //3. Parcours et mise à jour du titre des proverbes
    foreach($proverbs as $proverb) {
      $title = $proverb->getTitle();
      $title_no_quotes = $this->checkQuotes2($title);

      // s'il y a un moins un guillemet en position initiale ou finale
      $proverb->setTitle($title_no_quotes);
      $proverb->save();

    }

    // Test unitaires manuels
    $cas_1 = '"On est en ce monde enclume ou marteau."';
    $cas_2 = '"On est en ce monde enclume ou marteau.';
    $cas_3 = 'On est en ce monde enclume ou marteau."';
    $cas_4 = 'On est en ce monde enclume ou marteau.';

    //dpm($this->checkQuotes2($cas_1)); // OK
    //dpm($this->checkQuotes2($cas_2)); // OK
    //dpm($this->checkQuotes2($cas_3)); // OK
    //dpm($this->checkQuotes2($cas_4)); // OK

    return $this->redirect('proverb.list');

  }

}
