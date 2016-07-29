Feature: Order workflow for anonymous users
  In order to open the system to as many users as possible
  As anonymous user
  I need to be able to create and manage orders

@api
Scenario: Create an order
  Given I am an anonymous user
  And I am on "node/add/order"
  Then I should see the button "Save and Create New Draft"
  When I fill in the following:
    |title[0][value]|Some order|
    |field_email[0][value]|myemailaddress@mail.com|
  And I press "Save and Create New Draft"
  Then I should see the text "Order Some order has been created."
