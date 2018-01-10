<?php

namespace Drupal\intro;

class ProverbFactory {
  private $proverbs;

  public function __construct() {
    // source de données statique
    $this->proverbs = [
      'Tra il dire e il fare c\'è in mezzo il mare',
      'Pecunia beatos non reddit',
      'Ad astra per aspera',
      'Banii nu aduc fericirea',
      'Il ne faut pas vendre la peau...'
    ];

  }

  public function getProverbs() {
    return $this->proverbs;
  }

  public function getProverb() {
    // production d'un indice aléatoire
    $rand_index = rand(0, (sizeof($this->proverbs) - 1));
    return $this->proverbs[$rand_index];
  }

}
