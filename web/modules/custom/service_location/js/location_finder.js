/**
 * @file
 * Library which uses the google places api to search service locations.
 *
 * @todo we will maybe need to refactor this.
 */

(function ($, Drupal) {

  'use strict';

  /**
   * Initializes the location finder.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches the collapsible comments functionality.
   */
  Drupal.behaviors.locationFinderInit = {
    attach: function (context) {
      var $context = $(context);
      $('.find-location-link a', $context).once('find-location-link').on('click', function(e) {
        var map = $('<div class="map"></div>').insertAfter(this).get(0);
        var location_input = $(this).closest('.form-wrapper').find('input.form-text').get(0);
        Drupal.behaviors.locationFinderInit.initFinder(map, location_input);
        e.preventDefault();
      });
    },
    initFinder: function(map_element, location_input) {
      var map = new google.maps.Map(map_element, {
        // @todo: center based on current location!
        center: {lat: 0, lng: 0},
        zoom: 1,
        mapTypeId: 'roadmap',
        map_element: map_element,
        location_input: location_input
      });

      // Create the search box and link it to the UI element.
      var input = $(map_element).before('<input class="pac-input controls" type="text" placeholder="Search Box">').siblings('.pac-input').get(0);
      var searchBox = new google.maps.places.SearchBox(input);
      map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

      // Bias the SearchBox results towards current map's viewport.
      map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
      });
      var markers = [];
      // Listen for the event fired when the user selects a prediction and retrieve
      // more details for that place.
      searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
          return;
        }

        // Clear out the old markers.
        markers.forEach(function(marker) {
          marker.setMap(null);
        });
        markers = [];

        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
          if (!place.geometry) {
            console.log("Returned place contains no geometry");
            return;
          }
          var icon = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25)
          };

          // Create a marker for each place.
          var marker = new google.maps.Marker({
            map: map,
            icon: icon,
            title: place.name + ' ' + place.formatted_address,
            position: place.geometry.location
          });

          marker.addListener('click', function() {
            $(marker.map.location_input).val(marker.title);
          })
          markers.push(marker);

          if (place.geometry.viewport) {
            // Only geocodes have viewport.
            bounds.union(place.geometry.viewport);
          } else {
            bounds.extend(place.geometry.location);
          }
        });
        map.fitBounds(bounds);
      });
    }
  };

})(jQuery, Drupal);
