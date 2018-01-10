<?php

namespace Drupal\intro;

use Drupal\Core\Config\ConfigFactoryInterface;

class MessengerFactoryBis {

  private $config;
  
  // le paramètre $config en entrée du constructeur sera
  // alimentée par le service (la classe) déclarée dans le
  // fichier de configration intro.services.yml
  // ici : config.factory
  public function __construct(ConfigFactoryInterface $config) {
    $this->config = $config;
  }

  public function getMessage() {
    $c = $this->config->get('intro.custom_greeting');
    return $c->get('greet');
  }

}
