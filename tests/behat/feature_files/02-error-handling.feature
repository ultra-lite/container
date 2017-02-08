Feature: Basic error handling
    In order to debug issues
    As a user with an error in their DI config
    I want to pass be told what's going on

    Scenario: Asking for a thing that doesn't exist
        Given I have an empty container
        When I try to get the service ID 'std-class'
        Then the resulting error should be a '\Psr\Container\NotFoundExceptionInterface'
