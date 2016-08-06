<?php

/**
 * @file
 *  Contains \Drupal\account\Routing\RouteSubscriber
 */

namespace Drupal\account\Routing;


use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    // The userTitle() method of the UserController displays the username, but
    // we actually want to display the Display name.
    /* @var Route $route */
    foreach ($collection as $route) {
      if ($route->getDefault('_title_callback') == 'Drupal\user\Controller\UserController::userTitle') {
        $route->setDefault('_title_callback', 'Drupal\account\Controller\AccountController::userTitle');
      }
    }
  }
}
