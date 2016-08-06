<?php

/**
 * @file
 *  Contains \Drupal\account\Controller\AccountController
 */

namespace Drupal\account\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\user\Controller\UserController;
use Drupal\user\UserInterface;

class AccountController extends UserController {

  /**
   * {@inheritdoc}
   */
  public function userTitle(UserInterface $user = NULL) {
    return $user ? ['#markup' => $user->getDisplayName(), '#allowed_tags' => Xss::getHtmlTagList()] : '';
  }
}
