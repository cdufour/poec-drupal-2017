<?php
namespace Drupal\proverb\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

class CleanForm extends ConfigFormBase {

  private function transformTitle($title, $char, $action) {
    $newTitle = "";

    // on se débarrasse de l'éventuel saut de ligne
    if (ord(substr($title, -1)) == 13) {
      $newTitle = substr($title, 0, strlen($title)-1);
    } else {
      $newTitle = $title;
    }

    if ($action == "add") {
      $newTitle = $char . $newTitle . $char;
    }

    if ($action == "rem") {
      $newTitle = substr($newTitle, 1, strlen($newTitle)-2);
    }

    return $newTitle;
  }

  public function getEditableConfigNames() {}

  public function getFormId() {
    return 'proverb_clean_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['radios'] = array(
      '#type' => 'radios',
      '#title' => $this->t(''),
      '#description' => '',
      '#options' => array(
        'add' => $this->t('Ajouter'),
        'rem' => $this->t('Enlever')
      ),
      '#default_value' => 'add'
    );

    $form['char'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Caractère'),
      '#description' => '',
      '#default_value' => '',
    );

    $options = [
      'article' => 'article',
      'proverb' => 'proverb'
    ];
    $form['select'] = array(
      '#type' => 'select',
      '#title' => $this->t('Type de node'),
      '#description' => '',
      '#options' => $options
    );

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    // récupération des valeurs du formulaire
    $action     = $form_state->getValue('radios');
    $char       = $form_state->getValue('char');
    $node_type  = $form_state->getValue('select');

    // récupération des nids for le type de node sélectionné
    $query = \Drupal::entityQuery('node');
    $query->condition('type', $node_type);
    $nids = $query->execute();

    // chargement des entités correspondantes
    $nodes = Node::loadMultiple($nids);

    // parcourt et mise à jour du titre des nodes
    foreach($nodes as $node) {
      $title = $node->getTitle();
      $newTitle = $this->transformTitle($title, $char, $action);
      $node->setTitle($newTitle);
      $node->save();
    }

  }

}
