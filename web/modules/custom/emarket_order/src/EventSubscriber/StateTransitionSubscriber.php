<?php

/**
 * @file
 *  Contains \Drupal\emarket_order\EventSubscriber\StateTransitionSubscriber
 *
 * @todo: This is just a fast implementation of a proof of concept, the code and
 * the architecture should be refactored if this project will have success. This
 * is a must before doing any other new features after the project is released!
 */

namespace Drupal\emarket_order\EventSubscriber;

use Drupal\node\NodeInterface;
use Drupal\workbench_moderation\Event\WorkbenchModerationEvents;
use Drupal\workbench_moderation\Event\WorkbenchModerationTransitionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StateTransitionSubscriber implements EventSubscriberInterface {

  /**
   * Callback for the state transition event.
   */
  public function checkStateTransition(WorkbenchModerationTransitionEvent $event) {
    // There are a few state transitions for which we are currently interested
    // because we need to notify different entities (the author, the service
    // provider, etc).
    $entity = $event->getEntity();
    $state_before = $event->getStateBefore();
    $state_after = $event->getStateAfter();
    // We are interested in the state transition only if it affects an order.
    if ($entity->getEntityTypeId() == 'node' && $entity->getType() == 'order') {
      $transitions = $this->getInterestedStateTransitions();
      foreach ($transitions as $transition_key => $transition_info) {
        if ($transition_info['from'] == $state_before && $transition_info['to'] == $state_after) {
          $id = $entity->id();
          // For the case when the entity is inserted, we do not have yet the id
          // so we postpone the notification for later (in a shutdown function).
          // This is possible because we have the uuid here already.
          if (empty($id)) {
            drupal_register_shutdown_function('emarket_order_notification_shutdown_callback', $entity->uuid(), $transition_key);
          }
          else {
            emarket_order_notify($entity, $transition_key);
          }
          break;
        }
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[WorkbenchModerationEvents::STATE_TRANSITION][] = array('checkStateTransition');
    return $events;
  }

  /**
   * Returns an array with all the state transitions for which this module is
   * interested in for sending notifications.
   */
  protected function getInterestedStateTransitions() {
    return array(
      // As a naming convention, the key of each element of the array is the
      // concatenation of the 'from' and 'to' states having the '_' character as
      // separator.
      '_draft' => array(
        'from' => '',
        'to' => 'draft',
      ),
      'draft_submitted' => array(
        'from' => 'draft',
        'to' => 'submitted',
      ),
    );
  }
}
