@evo_user_impersonator
Feature: Show user impersonator hint
    In order to know if a user has been impersonated
    As a User who is allowed to impersonate
    I want to see the User Impersonated string on the Shop

    Background:
        Given the store operates on a single channel in "United States"
        And there is an administrator "lillytoy@hotmail.com" identified by "Lilly Toy" and "sylius"
        And there is a customer "Damien Hand" identified by an email "paucekfaye@yahoo.com" and a password "syliuscustomer"
        And I am logged in as "lillytoy@hotmail.com" administrator
        And the store has a product "Dress"

    @ui
    Scenario: Show customer impersonate hint by default
        When I view details of the customer "paucekfaye@yahoo.com"
        And I impersonate them
        And I visit the store
        Then I should be logged in as "Damien Hand"
        And I should see the impersonated user hint by "lilly toy"
        Then I added product "Dress" to the cart
        And I proceed to the checkout
        Then I should see the user impersonated hint by "lilly toy" on the checkout page

    @ui
    Scenario: Show customer impersonate hint is enabled
        When Channel "United States" has show user impersonate hint "enabled"
        And I view details of the customer "paucekfaye@yahoo.com"
        And I impersonate them
        And I visit the store
        Then I should be logged in as "Damien Hand"
        And I should see the impersonated user hint by "lilly toy"
        Then I added product "Dress" to the cart
        And I proceed to the checkout
        Then I should see the user impersonated hint by "lilly toy" on the checkout page

    @ui
    Scenario: Show customer impersonate hint is disabled
        When Channel "United States" has show user impersonate hint "disabled"
        And I view details of the customer "paucekfaye@yahoo.com"
        And I impersonate them
        And I visit the store
        Then I should be logged in as "Damien Hand"
        And I should not see the impersonated user hint
        Then I added product "Dress" to the cart
        And I proceed to the checkout
        Then I should not see the user impersonated hint on the checkout page

    @ui
    Scenario: Do not show customer impersonate hint as a normal customer user
        When Channel "United States" has show user impersonate hint "disabled"
        And I log out from my admin account
        And I visit the store
        And I log in as "paucekfaye@yahoo.com"
        And I should not see the impersonated user hint
        Then I added product "Dress" to the cart
        And I proceed to the checkout
        Then I should not see the user impersonated hint on the checkout page


    @ui
    Scenario: Do not show customer impersonate hint anymore after customer re-login in the shop
        When Channel "United States" has show user impersonate hint "enabled"
        And I view details of the customer "paucekfaye@yahoo.com"
        And I impersonate them
        And I visit the store
        Then I should see the impersonated user hint by "lilly toy"
        When I log out from the store
        And I log in as "paucekfaye@yahoo.com"
        Then I should not see the impersonated user hint

    @ui
    Scenario: Do not show customer impersonate hint anymore after re-login after admin logs out
        When Channel "United States" has show user impersonate hint "enabled"
        And I view details of the customer "paucekfaye@yahoo.com"
        And I impersonate them
        And I visit the store
        Then I should see the impersonated user hint by "lilly toy"
        When I log out from my admin account
        And I log in as "paucekfaye@yahoo.com"
        Then I should not see the impersonated user hint

