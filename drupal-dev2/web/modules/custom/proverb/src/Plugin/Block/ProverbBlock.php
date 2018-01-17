<?php

namespace Drupal\proverb\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;

/**
 * @Block(
 *  id = "proverb_list_block",
 *  admin_label = "Proverb Block"
 * )
 *
 */
class ProverbBlock extends BlockBase {

  public function build() {

    $query = \Drupal::EntityQuery('node');
    $query->condition('type', 'proverb');
    $nids = $query->execute();

    $proverbs = Node::loadMultiple($nids);

    $items = [];
    foreach($proverbs as $proverb) {
      $items[] = $proverb->getTitle();
    }

    return [
      '#theme' => 'item_list',
      '#items' => $items
    ];

  }

}
