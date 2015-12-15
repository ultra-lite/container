Feature: Basic setting and getting
    In order to set dependencies
    As a user configuring a container
    I want to put factory closures into the container, and get dependencies out

    Scenario: Putting a factory closure into the container and getting the dependency
        Given I have an empty container
        And I have a factory closure which returns a new '\stdClass'
        When I set the service ID 'std-class' with my factory closure
        And I get the service ID 'std-class'
        Then the result should be a '\stdClass' object

    Scenario: Getting the same object twice
        Given I have an empty container
        And I have a factory closure which returns a new '\stdClass'
        When I set the service ID 'std-class' with my factory closure
        And I get the service ID 'std-class'
        And I add a property 'x' to the result
        And I get the service ID 'std-class' again
        Then the result should have the property 'x' on it
