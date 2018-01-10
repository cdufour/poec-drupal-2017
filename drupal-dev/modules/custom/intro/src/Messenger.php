<?php

namespace Drupal\intro;

class Messenger {

  private $message;

  public function __construct() {
    $this->message = "Message par défaut sublimissime";
  }

  public function getMessage() {
    // Version utilisant les conteneur de services
    // l'instanciation de la classe désignée par le service est implicite

    // récupération du Container général de l'ensemble des
    // services (classes) déclarés par les différents modules
    $container = \Drupal::getContainer();

    // récupération du service config.factury qui permet
    // d'intéragir avec la table Config de la base de données
    $config = $container->get('config.factory');

    // récupération de la collection de clés/valeurs enregistrées
    // sous le nom intro.custom_greeting'
    $c = $config->get('intro.custom_greeting');

    //return $this->message;

    // on retourne la valeur associée à la clé 'greet' (ex: Bonne santé)
    return $c->get('greet');
  }

  public function getMessageBis() {
    // Version n'utilisant pas le conteneur de services
    // on doit faire une instanciation explicite

    // $config = new \Drupal\Core\Config\ConfigFactoryInterface;
    // renvoie l'erreur:
    // Message 	Error: Cannot instantiate interface
    // Drupal\Core\Config\ConfigFactoryInterface
    // Les classes appartenant au Core du Drupal doivent
    // être instanciées via le Conteneur de services


    //$c = $config->get('intro.custom_greeting');
    //return $c->get('greet');
  }

}
