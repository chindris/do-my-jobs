<?php

/**
 * @file
 *  Contains \Drupal\custom\Routing\RouteSubscriber
 */

namespace Drupal\custom\Routing;


use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RouteSubscriber
 * @package Drupal\custom\Routing
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    // We deny the access to the node/add page unless the user has admin rights.
    if ($route = $collection->get('node.add_page')) {
      $route->setRequirement('_permission', 'administer nodes');
    }
  }
}
