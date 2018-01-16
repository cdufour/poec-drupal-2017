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
    $checked_char = "\"";

    $firstChar = substr($str, 0, 1);
    $lastChar = substr($str, -1);

    if ($firstChar == $checked_char) {
      dpm("premier caractère = guillemet");
      // Le premier caractère est un guillemet

      // nouvelle chaîne sans le guillement initial
      $new_str = substr($str, 1);

      $lastChar = substr($new_str, -1);

      if ($lastChar == $checked_char) {
        // Le dernier caractère est guillemet
        dpm("dernier caractère = guillemet");
        $new_str = substr($new_str, 0, strlen($new_str)-1);
      }

    } else {
      // Le premier caractère n'est pas un guillemet
      // $new_str reçoit une copie de la chaîne passe en entrée
      $new_str = $str;

      if ($lastChar == $checked_char) {
        // Le dernier caractère est guillemet
        dpm("dernier caractère = guillemet");
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
      //dpm($this->checkQuotes($title));
      // if ($this->checkQuotes($title)) {
      //   $proverb->setTitle($this->noQuotes($title));
      //   $proverb->save();
      // }

    }

    // Test unitaires manuels
    $cas_1 = '"On est en ce monde enclume ou marteau."';
    $cas_2 = '"On est en ce monde enclume ou marteau.';
    $cas_3 = 'On est en ce monde enclume ou marteau."';
    $cas_4 = 'On est en ce monde enclume ou marteau.';

    //dpm($this->checkQuotes2($cas_1)); // OK
    //dpm($this->checkQuotes2($cas_2)); //  OK
    //dpm($this->checkQuotes2($cas_3)); // OK
    //dpm($this->checkQuotes2($cas_4)); // OK

    //return $this->redirect('proverb.list');
    return ['#markup' => 'fdfd'];
  }

}
