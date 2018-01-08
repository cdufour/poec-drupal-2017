<?php
namespace Drupal\intro\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller de test
 */
class IntroController extends ControllerBase {

  private $message = "Meilleurs voeux !";

  /**
   * Méthode coucou
   *
   * @return array
   */
  public function coucou() {
    // renvoie d'un tableau associatif (render array) avec certaines
    // clés permettant au système de rendu de Drupal
    // de créer/composer la réponse à retourner au client

    $res = '';
    $res .= '<ul>';
    $res .= '<li>A</li>';
    $res .= '<li>B</li>';
    $res .= '<li>C</li>';
    $res .= '</ul>';

    return [
      '#markup' => $res,
      'perso' => 'ce que je veux'
    ];

  }

  /**
   * Méthode list
   *
   * @return array
   */
  public function greet() {
    $default_message = "Ciao";
    $output = '';
    // if ($message != '') {
    //   $output = $message;
    // } else {
    //   $output = $this->message;
    // }
    $config = $this->config('intro.custom_greeting');
    $message = $config->get('greet');

    // si Drupal ne trouve aucune valeur associée à la clé
    // demandée (greet) dans la table Config, on renvoie au client
    // une valeur par défaut
    $output = ($message != '') ? $message : $default_message;

    return [
      '#markup' => $output
    ];

  }


}
