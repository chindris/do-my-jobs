Feature: Access to pages

Scenario: Anonymous access to the node add page
  Given I am an anonymous user
  When I am on "node/add"
  Then the response status code should be 403

Scenario: Anonymous access to the add order page
  Given I am an anonymous user
  When I am on "node/add/order"
  Then the response status code should be 200

Scenario: Anonymous access to the add order item page
  Given I am an anonymous user
  When I am on "node/add/order_item"
  Then the response status code should be 403