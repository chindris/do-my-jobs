<?php

/**
 * @file
 *  Contains \Drupal\custom\AlterableStateTransitionValidation
 */

namespace Drupal\custom;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\workbench_moderation\StateTransitionValidation;

/**
 * Overwrites the Drupal\workbench_moderation\StateTransitionValidation to add
 * the possibility to alter the valid state transitions by other modules.
 */
class AlterableStateTransitionValidation extends StateTransitionValidation {

  /**
   * @var ModuleHandlerInterface $moduleHandler
   *  The module handler service.
   */
  protected $moduleHandler;

  /**
   * {@inheritdoc}
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, QueryFactory $query_factory, ModuleHandlerInterface $module_handler) {
    parent::__construct($entity_type_manager, $query_factory);
    $this->moduleHandler = $module_handler;
  }

  /**
   * {@inheritdoc}
   */
  public function getValidTransitions(ContentEntityInterface $entity, AccountInterface $user) {
    $transitions = parent::getValidTransitions($entity, $user);
    $this->moduleHandler->alter('workbench_moderation_valid_transitions', $transitions, $entity, $user);
    return $transitions;
  }

}
