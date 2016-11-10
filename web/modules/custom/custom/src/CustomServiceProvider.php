<?php

/**
 * @file
 *  Contains \Drupal\custom\CustomServiceProvider
 */

namespace Drupal\custom;


use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;
use Symfony\Component\DependencyInjection\Reference;

class CustomServiceProvider extends ServiceProviderBase {

  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container) {
    // Overrides content_moderation.state_transition_validation class to
    // provide a possibility to alter the valid state transitions.
    $definition = $container->getDefinition('content_moderation.state_transition_validation');
    $definition->setClass('Drupal\custom\AlterableStateTransitionValidation');
    $definition->addArgument(new Reference('module_handler'));
  }
}
