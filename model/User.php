<?php
include_once "Contribution.php";
include_once "../db/DBHandler.php";

class User {
  private $username;
  private $name;
  private $roles;
  private $email;
  private $password;

  private function save() {
    $dbHandler = DBHandler::getInstance();

    $statement = "UPDATE fundit_user SET name={$name}, roles={$roles}, email={$email}, password={$password} WHERE username={$username}";
    $dbHandler->execute($statement, false);
  }

  private function fetchContribution() {
    $dbHandler = DBHandler::getInstance();

    $statement = "SELECT * FROM fundit_contribution WHERE contributor_username = {$username}";
    $result = $dbHandler->execute($statement, true);
  }

  public static function createNewUser($name, $roles, $email, $password) {
    $dbHandler = DBHandler::getInstance();

    $statement = "INSERT INTO fundit_user (name, roles, email, password) VALUES ({$name}, {$roles}, {$email}, {$password})";
    $dbHandler->execute($statement, false);

    $statement = "SELECT fundit_user_seq.CURRVAL FROM dual";
    $result = $dbHandler->execute($statement, true);

    $username = int($result['CURRVAL']);
    return new User($username, $name, $roles, $email, $password);
  }

  public function __construct($username, $name, $roles, $email, $password) {
    $this->username = $username;
    $this->name = $name;
    $this->roles = $roles;
    $this->email = $email;
    $this->password = $password;
  }

  public function getName($name) {
    return $this->name;
  }

  public function setName($name) {
    $this->name = $name;
    return $this->save();
  }

  public function getRoles($roles) {
    return $this->roles;
  }

  public function setRoles($roles) {
    $this->roles = $roles;
    return $this->save();
  }

  public function getEmail($email) {
    return $this->email;
  }

  public function setEmail($email) {
    $this->email = $email;
    return $this->save();
  }

  public function setPassword($password) {
    $this->password = $password;
    return $this->save();
  }

  public static function getUser($username) {
    $dbHandler = DBHandler::getInstance();

    $statement = "SELECT * FROM fundit_user WHERE username = {$username}";
    $result = $dbHandler->execute($statement, true);

    return new User($result->username, $result->name, $result->roles,
      $result->email, $result->password);
  }

  public function getContribution() {
    $contributions = fetchConstribution();
    $totalContribution = 0;
    foreach ($contributions as $contribution) {
      $totalContributions += $contribution['amount'];
    }
    return $totalContributions;
  }
}
?>