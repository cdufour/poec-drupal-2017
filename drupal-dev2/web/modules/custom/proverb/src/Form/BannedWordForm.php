<?php
namespace Drupal\proverb\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class BannedWordForm extends ConfigFormBase {

  public function getEditableConfigNames() {
    return ['proverb.banned_word'];
  }

  public function getFormId() {
    return 'banned_word_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['banned_word'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Mot à bannir'),
      '#description' => '',
      '#default_value' => ''
    );

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $word = $form_state->getValue('banned_word');

    // La Config n'est pas adaptée à notre situation
    // Il faudrait calculer des indices de clés
    // Ce n'est pas le but du service config.factory

    // $this->config('proverb.banned_word')
    //   ->set('word', $word)
    //   ->save();

    // Plus approprié : utilisation du service database
    // Insertion dans la table personnalisée banned_word
    $db = \Drupal::service('database');
    $fields = array('word' => $word);
    $db
      ->insert('banned_word')
      ->fields($fields)
      ->execute();

    return parent::submitForm($form, $form_state);

  }

}
