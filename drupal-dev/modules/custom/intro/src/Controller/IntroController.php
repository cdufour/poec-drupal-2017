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
    $output_final = '';
    // if ($message != '') {
    //   $output = $message;
    // } else {
    //   $output = $this->message;
    // }
    $config = $this->config('intro.custom_greeting');
    $message = $config->get('greet');

    // récupération du paramètre de configuration et conversion en entier
    $greet_num = (int) $config->get('greet_num');
    //var_dump($greet_num);

    $greet_num_enabled = (bool) $config->get('greet_num_enabled');

    // si Drupal ne trouve aucune valeur associée à la clé
    // demandée (greet) dans la table Config, on renvoie au client
    // une valeur par défaut
    $output = ($message != '') ? $message : $default_message;

    if ($greet_num_enabled) {
      for($i=0; $i<$greet_num; $i++) {
        $output_final .= '<p>' . ($i+1) . ' ' . $output . '</p>';
      }
    } else {
      $output_final = $output;
    }


    return [
      '#markup' => $output_final
    ];

  }


}
