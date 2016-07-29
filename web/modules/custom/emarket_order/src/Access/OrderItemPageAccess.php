<?php

/**
 * @file
 *  Contains \Drupal\emarket_order\Access\OrderItemPageAccess
 */
namespace Drupal\emarket_order\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\NodeTypeInterface;

/**
 * Class OrderItemPageAccess
 * @package Drupal\emarket_order\OrderItemPageAccess
 */
class OrderItemPageAccess implements AccessInterface {

  /**
   * Checks if the user can have access to the node add page, for the order
   * item nodes.
   *
   * @param \Drupal\Core\Routing\Access\AccessInterface $account
   *  The user for which the access is checked.
   * @param \Drupal\node\NodeTypeInterface $node_type
   *  The node type.
   *
   * @return \Drupal\Core\Access\AccessResult
   */
  public function access(AccountInterface $account, NodeTypeInterface $node_type) {
    if ($node_type->id()   == 'order_item' && !$account->hasPermission('administer nodes')) {
      return AccessResult::forbidden();
    }

    // No opinion.
    return AccessResult::allowed();
  }
}
