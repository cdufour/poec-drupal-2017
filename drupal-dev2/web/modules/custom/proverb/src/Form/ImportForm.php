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

    $form['tf'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Import depuis URL'),
      '#description' => '',
      '#default_value' => 'http://www.poesie-poemes.com/citations-latines.php'
    );
    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $value_ta = $form_state->getValue('ta');
    $value_tf = $form_state->getValue('tf');

    if ($value_ta != '') {

      // conversion de la chaîne de caractères en tableau de proverbes
      $proverbs = explode(PHP_EOL, $value); // EOL = End Of Line

      foreach($proverbs as $proverb) {
        // Enregistrer un node de type proverb dans le système

        // TO DO: améliorer le traitement
        // afin de ne pas enregistrer le titre du node
        // avec un saut de ligne (13 dans la table ASCII)
        // parasite

        $node = Node::create([
          'type' => 'proverb',
          'title' => $proverb
        ]);
        $node->save();

    }

    }

    if (isset($value_tf)) {
      // requête curl
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $value_tf
      ));
      $res = curl_exec($curl);

      $pattern = '/(?<=<p>)[A-Za-z ,æ]+/';
      preg_match_all($pattern, $res, $matches);

      foreach($matches[0] as $match) {
        // if (strstr($match, 'æ') != false) {
        //   dpm('caractère illicite trouvé');
        // }
        if (strlen($match) > 3 &&
        strstr($match, 'æ') == false) {
          $node = Node::create([
            'type' => 'proverb',
            'title' => $match
          ]);
          //$node->save();
        }
      }

    }

    //return parent::submitForm($form, $form_state);
  }

}
