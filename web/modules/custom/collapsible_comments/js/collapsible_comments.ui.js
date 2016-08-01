/**
 * @file
 * Defines Javascript behaviors for the collapsible_comments module.
 */

(function ($, Drupal) {

  'use strict';

  /**
   * Initializes the collapsible comments functionality.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches the collapsible comments functionality.
   */
  Drupal.behaviors.collapsibleCommentsInit = {
    attach: function (context) {
      var $context = $(context);
      var location_hash = window.location.hash;
      if (location_hash != '') {
        location_hash = location_hash.substr(1);
      }
      $context.find('.collapsible-comments').each(function () {
        var wrapper_list = $(this).find('.comments-wrapper-list');
        if (wrapper_list.get(0)) {
          // Move the add comment forms inside the list.
          $(this).find('h2.comment-form__title').appendTo(wrapper_list);
          $(this).find('form.comment-form').appendTo(wrapper_list);
        }
        else {
          wrapper_list = $(this).find('form.comment-form');
        }
        // Hide the wrapper list, but not if we have the fragment part of the
        // current window pointing to one of the comments in the list.
        if (location_hash == '' || !wrapper_list.find('a#' + location_hash).get(0)) {
          wrapper_list.hide();
        }
        $(this).find('h2').first().wrap('<a href="#"></a>').bind('click', function(e) {
          wrapper_list.slideToggle();
          e.stopPropagation();
          e.preventDefault();
        });
      });
    }
  };

})(jQuery, Drupal);
