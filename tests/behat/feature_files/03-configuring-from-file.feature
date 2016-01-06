Feature: Configuring the container from a file
    In order to add a full DI config for my application to the container
    As a user building a large application
    I want to pass a file path to my container to configure it

    Background:
        Given I have an empty container

    Scenario: Configuring the container from a file
        Given I have a config file at './tests/fixtures/example-config.php'
        When I tell the container to read the config file at './tests/fixtures/example-config.php'
        And I get the service ID 'std-class'
        Then the result should be a '\stdClass' object
