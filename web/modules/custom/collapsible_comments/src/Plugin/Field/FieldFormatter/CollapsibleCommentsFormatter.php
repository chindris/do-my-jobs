<?php

/**
 * @file
 *  Contains \Drupal\collapsible_comments\Plugin\Field\FieldFormatter\CollapsibleCommentsFormatter
 */

namespace Drupal\collapsible_comments\Plugin\Field\FieldFormatter;

use Drupal\comment\Plugin\Field\FieldFormatter\CommentDefaultFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Render\Element;

/**
 * @FieldFormatter(
 *   id = "collapsible_comments",
 *   module = "collapsible_comments",
 *   label = @Translation("Collapsible comment list"),
 *   field_types = {
 *     "comment"
 *   },
 *   quickedit = {
 *     "editor" = "disabled"
 *   }
 * )
 */
class CollapsibleCommentsFormatter extends CommentDefaultFormatter {

  public function viewElements(FieldItemListInterface $items, $langcode) {
    $build = parent::viewElements($items, $langcode);
    $build['#attributes']['class'][] = 'collapsible-comments';
    $build['#attached']['library'][] = 'collapsible_comments/collapsible_comments.ui';
    foreach (Element::children($build) as $key) {
      if (!empty($build[$key]['comments'])) {
        $build[$key]['comments']['#prefix'] = '<div class="comments-wrapper-list">';
        $build[$key]['comments']['#suffix'] = '</div>';
      }
    }
    return $build;
  }
}
