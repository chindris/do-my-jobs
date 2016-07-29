<?php

/**
 * @file
 *  Contains \Drupal\emarket_order\Routing\RouteSubscriber
 */

namespace Drupal\emarket_order\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RouteSubscriber
 * @package Drupal\emarket_order\Routing
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    // We add a custom access handler to the node.add route because we want to
    // deny the access to that page for order items (we do not want to deny the
    // access to create these items, for example when using the inline entity
    // form, just deny the access to the web page).
    if ($route = $collection->get('node.add')) {
      $route->setRequirement('_custom_access', '\Drupal\emarket_order\Access\OrderItemPageAccess::access');
    }
  }
}