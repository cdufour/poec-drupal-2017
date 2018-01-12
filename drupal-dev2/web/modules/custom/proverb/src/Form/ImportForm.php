<?php
namespace Drupal\proverb\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

class ImportForm extends ConfigFormBase {

  public function getEditableConfigNames() {}

  public function getFormId() {
    return 'proverb_import_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['ta'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Import'),
      '#description' => 'Coller vos proverbes ici',
      '#default_value' => ''
    );
    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $value = $form_state->getValue('ta');

    // conversion de la chaîne de caractères en tableau de proverbes
    $proverbs = explode(PHP_EOL, $value); // EOL = End Of Line

    foreach($proverbs as $proverb) {
      // Enregistrer un node de type proverb dans le système
      $node = Node::create([
        'type' => 'proverb',
        'title' => $proverb
      ]);
      $node->save();

    }
    return parent::submitForm($form, $form_state);
  }

}
