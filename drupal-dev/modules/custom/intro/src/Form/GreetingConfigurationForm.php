<?php
namespace Drupal\intro\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Formulaire de configuration du message de souhait
 */
class GreetingConfigurationForm extends ConfigFormBase {

  public function getEditableConfigNames() {
    return ['intro.custom_greeting'];
  }

  public function getFormId() {
    return 'greeting_configuration_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('intro.custom_greeting');
    // ajout d'un champ texte au formulaire

    // la  méthode t (translate), héritée, permet d'enregistrer la
    // chaîne de caractères passée en entrée auprès du module de traduction
    $form['greeting'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Message de souhait'),
      '#description' => $this->t('Merci de fournir votre message'),
      '#default_value' => $config->get('greet')
    );

    // renvoie du tableau associatif via la méthode buildForm
    // par la classe parente (ConfigFormBase)
    return parent::buildForm($form, $form_state);

  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('intro.custom_greeting')
      ->set('greet', $form_state->getValue('greeting'))
      ->save(); // déclenche une requête SQL INSERT INTO

    parent::submitForm($form, $form_state); // traitement de la requête HTTP
  }

}
