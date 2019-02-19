Feature: Books feature
  Scenario: Adding a new book
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "POST" request to "/books" with body:
    """
    {
      "title": "King",
      "author": "T. M. Frazier",
      "enabled": true
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON nodes should contain:
      | title                   | King              |
      | author                  | T. M. Frazier     |
    And the JSON node "enabled" should be true
