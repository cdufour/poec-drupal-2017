<?php

namespace Drupal\proverb\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;

/**
 * @Block(
 *  id = "proverb_list_block",
 *  admin_label = "Proverb Block"
 * )
 *
 */
class ProverbBlock extends BlockBase {

  public function build() {
    $limit = 10; // defaut value
    $current_user = \Drupal::currentUser();
    $roles = $current_user->getRoles();
    if (in_array('administrator', $roles)) $limit = 5;
    if ($current_user->isAnonymous()) $limit = 3;

    $query = \Drupal::EntityQuery('node');
    $query->condition('type', 'proverb');
    $query->sort('nid', 'DESC');
    $query->range(0, $limit);
    $nids = $query->execute();

    $proverbs = Node::loadMultiple($nids);

    $items = [];
    foreach($proverbs as $proverb) {
      $nid = $proverb->id();
      $url = Url::fromRoute('entity.node.canonical', array('node' => $nid));
      $link = \Drupal::l($proverb->getTitle(), $url);
      $items[] = $link;
    }

    return [
      '#theme' => 'item_list',
      '#items' => $items
    ];

  }

}
